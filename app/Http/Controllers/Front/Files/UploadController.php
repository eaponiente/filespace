<?php

namespace App\Http\Controllers\Front\Files;

use Input;
use Auth;
use Session;
use App\Traits\FilesTrait;
use App\Models\FileUploads;
use App\Models\Filenas;
use App\Models\GlobalStats;
use App\Models\FileFolders;
use App\Models\Settings;
use App\Library\CustomUploadHandler;
use App\Library\FileProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
	use FilesTrait;

    public function postDoUpload(Request $request)
	{
		/*$data = $request->all();

		parse_str($data['data'], $info);

		$server = $info['server'];

		$user_auth = Auth::check() ? Auth::user()->id : 0;

		$settings = Settings::first() ? Settings::first() : null;

		if( $server['user_id'] )  
		{
			$user_details = User::find($server['user_id']);

			$storage = $user_details->custom_storage > 0 ? $user_details->custom_storage : $settings->registered_user_storage;

			if( $_FILES[ 'file' ][ 'size' ] > $storage ) 
			{
				return response()->json( array( 'files' => array( 0 => 'eg', 1 => 'ex' ) ) );
			}
		}

		$file_server = Filenas::get_file_servers();

		if ( ! $file_server )
		{
			die( "<h1>No available file servers</h1>" );
		}

		$options = [];

		$fp = new FileProcess();
		$info = new StdClass();

		$is_upload_md5_dupe = false;
		
		$url = $server['server_ip'];

		$upload_path = 'remote_uploads/';

		$filename = $this->generate_filename( $_FILES[ 'file' ][ 'name' ] );


		// 0 = filename with ext(ex. file.txt) 1 = filename (ex. filename) 2 = extension
		preg_match( '/(.*)(\..*)$/', $_FILES[ 'file' ][ 'name' ], $matches );

		$info->name 		= $file->getClientOriginalName();
		$info->size 		= $_FILES[ 'file' ][ 'size' ];
		$info->type 		= $_FILES[ 'file' ][ 'type' ];
		$info->title		= $matches[ 1 ];
		$info->success 		= true;
		$info->message 		= '';
		$info->delete_hash 	= '';

		$folder_id = $request->input('server.upload_to', '');

		$folder = null;
				
		Session::forget('upload_to_folder');

		if( !empty( $folder_id ) )
		{
			$folder = FileFolders::find($folder_id);
		}

		$delete_hash = $this->generate_delete_hash();

		$insert_id = null;*/

		$uploader = new CustomUploadHandler();
	}

	private function generate_delete_hash()
	{
		$hash = md5( uniqid() . ( mt_rand() * 1000 ) . time() . mt_rand() . mt_rand() . uniqid() );
		for ( $i = 0; $i < 30; $i++ )
		{
			$hash = md5( $hash . time() . microtime( true ) . uniqid() );
		}

		$query = FileUploads::where( 'delete_hash', $hash )->count();
		
		if ( $query > 0 )
		{
			return $this->generate_delete_hash();
		}
		
		return $hash;
	}

	private function get_fileserver()
	{
		$fileserver = Filenas::where('serverType', 'direct')->orderBy('space_used', 'ASC')->first();

		if( ! count( $fileserver ) )
		{
			$fileserver = Filenas::where('serverType', 'local')->first();
		}

		return $fileserver;
	}

	private function convertToBytes($from){
	    $number=substr($from,0,-2);
	    switch(strtoupper(substr($from,-2))){
	        case "KB":
	            return $number*1024;
	        case "MB":
	            return $number*pow(1024,2);
	        case "GB":
	            return $number*pow(1024,3);
	        case "TB":
	            return $number*pow(1024,4);
	        case "PB":
	            return $number*pow(1024,5);
	        default:
	            return $from;
	    }
	}

	private function generate_filename( $filename, $upload_dir = '' )
	{
		preg_match( '/\.[a-zA-Z0-9]+$/', $filename, $matches );
		
		$str = md5( uniqid() . ( mt_rand() * 1000 ) . time() . $filename . mt_rand() );
		if ( file_exists( $upload_dir . $str . $matches[ 0 ] ) )
		{
			return $this->generate_filename( $filename, $upload_dir );
		}
		
		return $upload_dir . $str . $matches[ 0 ];
	}

	private function upload_remote_direct( $source, $file_real, $server, $fp_dir )
	{
		// initialise the curl request
		$request 	= curl_init( $server[ 'fileServerDomainName' ] . 'test/fileshare/' . $server[ 'scriptPath' ] );
		//$request = 'http://localhost/'
		$path_info 	= pathinfo( $source );

		$POST_DATA = [
			'accessAuth'	=> Config::get('constants.direct_remote_auth_access'),
			'storagePath' 	=> str_finish($server[ 'storagePath' ], '/'),
			'directory' 	=> $fp_dir,
			'filename'		=> $file_real[ 'filename' ],
			'extension'		=> $file_real[ 'extension' ],
			'file' 			=> '@' . realpath( $source )
		];
		
		// send a file
		@curl_setopt( $request, CURLOPT_POST, true );
		@curl_setopt( $request, CURLOPT_POSTFIELDS, $POST_DATA );

		// output the response
		@curl_setopt( $request, CURLOPT_RETURNTRANSFER, true );
		$exec = curl_exec( $request );

		// check if curl has error
		if($errno = curl_errno($request)) {
        $error_message = curl_strerror($errno);
	       die( "cURL error ({$errno}):\n {$error_message}");
	    } 

		// close the session
		curl_close( $request );
		
		return $exec;
	}

	private function checkRemoteFile($url)
	{
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_NOBODY, 1);
	    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	    return curl_exec($ch) !== FALSE ? true : false;
	}

}
