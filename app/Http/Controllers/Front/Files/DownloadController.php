<?php

namespace App\Http\Controllers\Front\Files;

use Auth;
use DB;
use Session;
use URL;
use Validator;
use App\Models\DownloadTracker;
use App\Models\DownloadToken;
use App\Models\FileFolders;
use App\Models\Filenas;
use App\Models\Fileserver;
use App\Models\FileUploads;
use App\Models\GlobalStats;
use App\Models\Settings;
use App\Models\UserStats;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function fileDownload(Request $request, $enc_file = null )
	{
		if( is_null( $enc_file ) || strlen( $enc_file ) != 20 )
		{
			return view('front.download.file-not-found');
		}
		else
		{
			$ids = syferDecode( $enc_file );

			$siteid = $ids[ 'siteid' ];

			$fileid = (int) $ids[ 'fileid' ];

			$file = FileUploads::find( $fileid );

			if( empty( $file ) )			
			{	
				return view('front.download.file-not-found');
			}
			else
			{
				$user = User::find( Auth::check() ? Auth::id() : null );
				$settings = Settings::all()->first();

				$seconds_interval = false;

				$last_download_date = DownloadTracker::where('ip_address', $request->getClientIp())->orderBy('date_started', 'DESC')->first();


				if( $last_download_date )
				{
					//if ( Session::has( 'download_time' ) )
					//{
					
						$download_date = strtotime( $last_download_date->date_started );

						$diff = time() - $download_date;
						$interval = (int) ( Auth::check() 
										? $settings->register_user_download_interval 
										: $settings->free_user_download_interval ) * 60;

						if( $diff < $interval )
						{
							$seconds_interval = $interval - $diff;
						}
						
					//}
				}

				if( Auth::check() )
				{
					if( strtotime(Auth::user()->premium_expiration_date_and_time) >= strtotime(date('Y-m-d H:i:s')) || 
						$file->user_id == Auth::id() )
					{
						$seconds_interval = false;
					}
				}

				$has_passwd = false;

				$settings = Settings::all()->first();

				$server_off = ! Fileserver::check_fileservers();

				Session::put('referring_url', URL::previous());

				return view( 'front.download.index', compact( 'file', 'user', 'settings', 'enc_file', 'seconds_interval', 'server_off', 'has_passwd' ) );

			}
		}
	}

	public function postDownloadBoot()
	{
		$settings = Settings::first();
		
		if ( !isset( $_POST[ 'send' ] ) )
		{
			//show_error( 'page' );
			//exit;
		}
		
		$json = array();
		$json[ 'success' ]			= true;
		$json[ 'delay' ] 			= Auth::check() ? $settings->register_users_delay : $settings->free_users_delay;
		$json[ 'download_token' ] 	= hash( 'sha256', microtime( true ) . uniqid() . time() . mt_rand( 0, 1000 ) . date( 'Ymdhis' ) );
		
		Session::put('download_token', $json[ 'download_token' ] );
		Session::put('download_time', time() );
		
		header( 'Content-type: application/json' );
		
		return response()->json( $json );
	}

	public function postCheckPassword()
	{
		$json = array();
		$json[ 'success' ] = false;

		$fileid = (int) $_POST[ 'file_id' ];
		
		if ( isset( $_POST[ 'password' ] ) && isset( $fileid ) )
		{
			$file = FileUploads::find( $_POST['file_id'] );
			
			$has_passwd = $file->password;

			if( $file->folder_id != 0 )
			{
				$folder = FileFolders::find( $file->folder_id );
				
				if( !empty($folder->password) )
				{
					$has_passwd = $folder->password;
				} else {
					$has_passwd = $file->password;
				}
			} else {
				$has_passwd = $file->password;
			}

			if ( $file )
			{
				if ( $has_passwd == $_POST[ 'password' ] )
				{
					$json[ 'success' ] = true;
				}
			}
		}
		
		header( 'Content-type: application/json' );

		return response()->json( $json );
	}

	public function getStreamFile(Request $request, $kryptId )
	{
		// put true on second param for short method 
		// if true syfer is included in function else syfer is not included
		$ids = syferDecode( $kryptId );

		$siteid = $ids[ 'siteid' ];

		$file_id = ( int ) $ids[ 'fileid' ];

		$file = FileUploads::find( $file_id );

		$server = Filenas::find($file->filenas_id);
		
		if ( empty( $file ) )
		{
			return redirect()->to('/');
		}
		
		$request_token 	= ! isset( $_GET[ 'token' ] ) ? null : $_GET[ 'token' ];
		$download_token = ! Session::has( 'download_token' ) ? md5( uniqid() . time() . microtime( true ) ) : Session::get( 'download_token' );
		
		/*if ( $request_token !== $download_token )
		{
			echo "<h1>Unauthorized Access</h1>";
			exit;
		}*/

		$file->update( array( 'last_download' => date( 'Y-m-d H:i:s' ) ));
		
		$settings = Settings::first();
		

		$user_id = Auth::check() ? Auth::user()->id : 0;
		$user 	 = User::find( $user_id );

		$finfo 	= function_exists( 'finfo_open' ) ? finfo_open( FILEINFO_MIME_TYPE ) : null;
		
		if ( function_exists( 'finfo_close' ) )
		{
			finfo_close( $finfo );
		}

		$download_speed = null;
		
		if( Auth::check() )
		{
			$download_speed = Auth::user()->is_affiliate == 'NO' ? $settings->register_user_max_download_speed : $settings->premium_user_max_download_speed;
			
		}else{ 
			$download_speed = $settings->free_user_max_download_speed;
		}
		
		$dt = new DownloadToken;
		$dt->token 		= $download_token;
		$dt->user_id 	= $user_id;
		$dt->ip_address = $request->getClientIp();
		$dt->file_id    = $file_id;
		$dt->created 	= date('Y-m-d H:i:s');
		$dt->expiry 	= date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '+1 day'));
		$dt->max_threads = 0;
		$dt->download_speed = $download_speed;
		$dt->save();

		$dtoken = $dt->token;

		$mainPath = $server->serverType == 'local' ? public_path() : str_finish($server->fileServerDomainName, '/' );
		
		$filepath = str_finish($mainPath, '/') . str_finish($server->storagePath, '/') . $file->file_path . $file->filename . '.' . $file->file_ext;

		$file->increment( 'total_downloads' );

		$this->serve_file_resumable($request, $filepath, $file_id, $file->title .'.'. $file->file_ext, $file->filenas_id );

		UserStats::stats('downloads');

		if( Auth::check() )
		{
			if( Auth::user()->id != $file->user_id )
			{
				$fileOwner = UserStats::where( 'user_id', $file->user_id )->where('date', date('Y-m-d'))->first();
				if( $fileOwner )
				{
					UserStats::where( 'user_id', $file->user_id )->where('date', date('Y-m-d'))->increment('bytes_downloaded', $file->filesize_bytes);		
				}
				else
				{
					UserStats::create([
						'user_id'	=> $file->user_id,
						'date'		=> date('Y-m-d'),
						'bytes_downloaded'	=> $file->filesize_bytes
					]);
				}
				UserStats::stats('files_download');


			}
			
		}

		GlobalStats::increment_columns('downloads');

		return redirect()->away($mainPath . 'file/'. $dtoken . '/' . $kryptId . '?ref=' . Session::get('referring_url'));
	}

	public function postCapcha(Request $request)
	{
		$validator = Validator::make( $request->all() , [
			'g-recaptcha-response' => 'required'
		]);


		if( $validator->fails())
		{
			return response()->json( array( 'success' => false ) );
		}
		
		return response()->json( array( 'success' => true ) );
	}

	public function serve_file_resumable($request, $file, $file_id, $file_title, $fs_id, $contenttype = 'application/octet-stream') 
	{
		if( Auth::guard('admin')->check() )
		{
			$fs = Filenas::find($fs_id);
			$file_temp = FileUploads::find( $file_id );
			$file = str_finish($fs->fileServerDomainName, '/') . str_finish($fs->storagePath, '/') . $file_temp->file_path . $file_temp->filename . '.' . $file_temp->file_ext;
			$file_title = $file_temp->title .'.'. $file_temp->file_ext;
		}

		$country_code = get_country_code( $request->getClientIp(), 'Country Code' );
    	$dt = new DownloadTracker;
    	$dt->file_id = $file_id;
    	$dt->ip_address = $request->getClientIp();
    	$dt->download_username = Auth::check() ? Auth::user()->username : null;
    	$dt->date_started = date('Y-m-d H:i:s');
    	$dt->download_country = $country_code;
    	$dt->referring_url = Session::get('referring_url');
    		$dt->save();
    	$dt_id = $dt->id; 

    	Session::forget('referring_url');

    	

	    // Avoid sending unexpected errors to the client - we should be serving a file,
	    // we don't want to corrupt the data we send

	    // Make sure the files exists, otherwise we are wasting our time
	    if ( ! @fopen( $file,"r" ) ) 
	    {
	    	
	      header("HTTP/1.1 404 Not Found");
	      exit;
	    }

	    $file_pending = DownloadTracker::where('download_username', Auth::check() ? Auth::user()->username : null )
	    				->where('ip_address', $request->getClientIp() )
	    				->where('file_id', $file_id)->orderBy('date_started', 'DESC')->first();
	    $pending = false;
	    if( count( $file_pending ) <= 0 || is_null( $file_pending ) )
	    {
	    	$pending = false;
	    }
	    else
	    {
	    	if( in_array( $file_pending->status, array( 'finished', 'error', 'cancelled' ) ) ) 
	    		$pending = false;
	    	else
	    		$pending = true;
	    }					

	    if( !$pending )
	    {
	    	
	    }	

	  

	    
	    
	    // Get the 'Range' header if one was sent
	    if (isset($_SERVER['HTTP_RANGE']) || isset($HTTP_SERVER_VARS['HTTP_RANGE'])) {
	    	$range = $_SERVER['HTTP_RANGE']; // IIS/Some Apache versions	    	
	    }
	    else if ($apache = $this->apache_request_headers()) 
	    { 
	    	// Try Apache again
	      	$headers = array();
	      	foreach ($apache as $header => $val) 
	      	{
	      		$headers[ strtolower( $header ) ] = $val;
	      	}

	      	$range = isset($headers['range']) ? $headers['range'] : FALSE;

	    } 
	    else 
	    {
	    	DownloadTracker::find( !$pending ? $dt_id : $file_pending->id )->update(array( 'status' => 'error' ));
	    	$range = FALSE; // We can't get the header/there isn't one set
	    }

	    

	    // Get the data range requested (if any)
	    //$filesize = filesize($file); // get filesize local

	    $filesize = $this->getSizeFile($file); // get filesize remote

	    
	    //Session::put('range', array('sdf' => 'tyutyu'));
	    if ( $range ) 
	    {
	      DownloadTracker::find( !$pending ? $dt_id : $file_pending->id )->update(array( 'status' => 'downloading' ));
	      $partial = true;
	      list($param,$range) = explode('=',$range);
	      if (strtolower(trim($param)) != 'bytes') 
	      { 
	      	// Bad request - range unit is not 'bytes'
	        header("HTTP/1.1 400 Invalid Request");
	        exit;
	      }

	      $range = explode( ',', $range );
	      $range = explode( '-', $range[0] ); // We only deal with the first requested range

	      if (count($range) != 2) 
	      { 
	      	// Bad request - 'bytes' parameter is not valid
	        header("HTTP/1.1 400 Invalid Request");
	        exit;
	      }

	      

	      if ($range[0] === '') 
	      { 
	      	// First number missing, return last $range[1] bytes
	        $end = $filesize - 1;
	        $start = $end - intval($range[0]);
	      } 

	      else if ($range[1] === '') 
	      { 
	      	// Second number missing, return from byte $range[0] to end
	        $start = intval($range[0]);
	        $end = $filesize - 1;
	      } 
	      else 
	      { 
	      	// Both numbers present, return specific range
	        $start = intval($range[0]);
	        $end = intval($range[1]);

	        if ($end >= $filesize || (!$start && (!$end || $end == ($filesize - 1)))) $partial = false; // Invalid range/whole file specified, return whole file
	      }      
	      

	      $length = $end - $start + 1;
	    } else $partial = false; // No range requested

	    // Send standard headers
	    header("Content-Type: $contenttype", true);
	    header("Pragma: public");
	    header("Content-Transfer-Encoding: Binary");
	    header("Content-Length: $filesize");
	    header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
	    header(sprintf('Content-Disposition: attachment; filename="%s"', $file_title));
	    header('Accept-Ranges: bytes');

	    // if requested, send extra headers and part of file...
	    if ($partial) 
	    {
	      header('HTTP/1.1 206 Partial Content'); 
	      header("Content-Range: bytes $start-$end/$filesize"); 

        	DownloadTracker::find( !$pending ? $dt_id : $file_pending->id )->update( array(
          	'start_offset'	=> $start,
          	'seek_end'		=> $end
          	));	

	      if (!$fp = fopen($file, 'r')) 
	      { 
	        // Error out if we can't read the file
	        DownloadTracker::find(  !$pending ? $dt_id : $file_pending->id  )->update(array( 'status' => 'error' ));
	        header("HTTP/1.1 500 Internal Server Error");
	        exit;
	      }
	      if ($start) 
	        fseek($fp,$start);
	      $settings = Settings::all()->first();
	      $download_speed = $settings->free_user_max_download_speed;
	      if( Auth::user()->check() )
			{
				$download_speed = strtotime(Auth::user()->premium_expiration_date_and_time) < strtotime(date('Y-m-d H:i:s')) 
						? $settings->register_user_max_download_speed 
						: $settings->premium_user_max_download_speed;
				
			}
	      while ($length) 
	      { 
	      	
	        // Read in blocks of 20KB so we don't chew up memory on the server
	        // 8192 original bytes
	        $read = ($length > 20480) ? $download_speed * 1024 : $length;
	        $length -= $read;
	        print( fread( $fp,1024 ) );
	        if (connection_status()!=0)
            {
              DownloadTracker::find( !$pending ? $dt_id : $file_pending->id )->update(array( 'status' => 'cancelled' ));	
              @fclose($file);
              exit;
            }
	      }
	      //DownloadTracker::find( $dt_id )->update(array( 'status' => 'finished' ));
	      fclose($fp); 
	    } 
	    else 
	    {
	    
	    DownloadTracker::find( !$pending ? $dt_id : $file_pending->id )->update(array( 'date_finished' => date('Y-m-d H:i:s'), 'status' => 'finished' ));	
	    ob_clean();	
	    readfile($file); // ...otherwise just send the whole file

		}
	    // Exit here to avoid accidentally sending extra content on the end of the file
	    exit;


  	}

  	private function apache_request_headers()
	{
		if( !function_exists('apache_request_headers') ) 
		{
		  $arh = array();
		  $rx_http = '/\AHTTP_/';
		  foreach($_SERVER as $key => $val) {
		    if( preg_match($rx_http, $key) ) {
		      $arh_key = preg_replace($rx_http, '', $key);
		      $rx_matches = array();
		      // do some nasty string manipulations to restore the original letter case
		      // this should work in most cases
		      $rx_matches = explode('_', $arh_key);
		      if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
		        foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
		        $arh_key = implode('-', $rx_matches);
		      }
		      $arh[$arh_key] = $val;
		    }
		  }
		  return( $arh );
		}
	}

	private function getSizeFile($url) 
  	{
		if (substr($url,0,4)=='http') 
		{
			$x = array_change_key_case(get_headers($url, 1),CASE_LOWER);
			if ( strcasecmp($x[0], 'HTTP/1.1 200 OK') != 0 ) 
			{ 
				$x = $x['content-length'][1]; 
			}
			else 
			{ 
				$x = $x['content-length']; 
			}
		}
		else 
		{ 
				$x = @filesize($url); 
		}

		return $x;
	} 
}
