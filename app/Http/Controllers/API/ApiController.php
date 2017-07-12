<?php

namespace App\Http\Controllers\API;

use App\Models\WebsiteCodes;
use Auth;
use DB;
use Session;
use Response;
use App\Traits\FilesTrait;
use App\Models\AbuseReport;
use App\Models\FileUploads;
use App\Models\Filenas;
use App\Models\User;
use App\Models\Settings;
use App\Models\FileFolders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
	use FilesTrait;

	public function __construct()
	{
		\Debugbar::disable();
	}

    public function getIp(Request $request)
	{
		ob_end_clean();

		$ip = $request->getClientIp();
		return $ip;
	}

	public function getGeolocation()
	{
		$cc = get_country_code( Request::getClientIp(), 'Country Code' );
		return $cc;
	}

	public function getCheckFileMd5(Request $request)
	{
		$query = FileUploads::whereFileMd5($request->file_md5)->first();

		return $query ?: null;
	}

	public function getFolders(Request $request)
	{
		$folder = FileFolders::find( $request->folder_id );

		return $folder ?: null;
	}

	public function getCheckServers()
	{
		$file_server = Filenas::get_file_servers();

		return response()->json( array( 
			'success'	=> empty($file_server) ? false : true,
		), 200);
	}

	public function generateFilename()
	{
		$str = md5( time() . ( uniqid() * mt_rand(10, 200) ) . uniqid() . mt_rand(1, 1000) );

		if( FileUploads::where('filename', $str)->first() )
		{
			return $this->generateFilename();
		}

		return response()->json([
			'status' => true,
			'filename' => $str
		]);	
	}

	public function getFilenas(Request $request)
	{
		$filenas = Filenas::find($request->filenas_id);

		return $filenas ?: null;
	}

	public function getGenerateDeleteHash()
	{
		$hash = md5( uniqid() . ( mt_rand() * 1000 ) . time() . mt_rand() . mt_rand() . uniqid() );

		for ( $i = 0; $i < 30; $i++ )
		{
			$hash = md5( $hash . time() . microtime( true ) . uniqid() );
		}

		$query = FileUploads::where( 'delete_hash', $hash )->count();
		
		if ( $query > 0 )
		{
			return $this->getGenerateDeleteHash();
		}
		
		return response()->json([
			'success' => true,
			'delete_hash' => $hash 
		]);
	}

	public function getUpdate($id, $data)
	{
		$info = FileUploads::find( $id );
		$data = rawurldecode($data);
		parse_str($data, $response);

		//$response['user_id'] = Auth::user()->check() ? Auth::user()->get()->id : 0;
		$info->update($response);

		return response()->json(array( 'success' => true));
	}

	public function getInsert(Request $request)
	{
		$insert = FileUploads::create($request->all());

		$insert->krypt_id = syferEncode($insert->id, WebsiteCodes::where('user id', 0)->first()->code );

		return $insert;
	}

	public function getIncrement(Request $request)
	{
		$ff = FileFolders::find( $request->folder_id );
		$ff->increment('total_files', 1); // update( array( 'total_files' => DB::raw('total_files + 1') ) );

		return response()->json(array( 'success' => true));
	}

	public function getFindMd5($file_md5)
	{
		$chs = FileUploads::whereFileMd5( $file_md5 )->first();

		return response()->json( $chs, 200 );
	}

	public function getUserLogged(Request $request)
	{
		return User::find($request->user_id) ? User::find($request->user_id) : 0;
	}

	public function getUserDetails( Request $request)
	{
		return User::find($request->user_id) ? User::find($request->user_id) : null;
	}

	public function getSettings()
	{
		return Settings::first() ? Settings::first() : null;
	}

	public function getUserCheck()
	{
		$siteId = Auth::check() ? Config::get('constants.site_id') : '';
		return response()->json( [ 'siteId' => $siteId ] );
	}

	public function getUpdateUserFileStat(Request $request)
	{
		if( $request->user_id )
		{
			$user = User::find( $request->user_id );

			if ( $request->increment || ( $user->storage_used >= $request->bytes && $user->files > 0 ) )
			{
				$user->update( array(
					'storage_used'	=> DB::raw( 'storage_used '. ( $request->increment ? '+' : '-' ) .' '. $request->bytes ),
					'files'			=> DB::raw( 'files '. ( $request->increment ? '+' : '-' ) .' 1' )
					) );

				$user = User::find( $user->id );

				$this->update_local_fileserver_stat( $request->increment, $request->bytes );
			}

			//Session::put( 'file_count', $user->files );
		}
		return response()->json( array('success' => true));
	}
	
	public function getUpdateFileServerSpace( $data, $increment = true, $size )
	{
		# 0 = Filenas ID , 1 = space used , 2 = number of files in server
		$server = explode('@@', $request->data);
		if ( $request->increment || ( $server[ 1 ] >= $request->size && $server[ 2 ] > 0 ) )
		{
			$filenas = Filenas::find( $server[ 0 ] );
			$filenas->update( array(
				'space_used'	=> DB::raw( 'space_used '. ( $request->increment ? '+' : '-' ) .' '. $request->size ),
				'files'			=> DB::raw( 'files '. ( $request->increment ? '+' : '-' ) .' 1' )
				) );
		}

		return response()->json( array('success' => true));
	}

	public function getIncrementGlobalStats()
	{
		GlobalStats::increment_columns('uploads');

		return response()->json(array('success' => true));
	}

	/********************************
	*								*		
	*								*
	*	User Abuse Upload API 		*
	*								*
	*								*
	*********************************/


	public function getUploadAbuse($data='')
	{
		$i = rawurldecode( $data );

		parse_str( $i, $response );

		AbuseReport::create( $response );

		return response()->json( [ 'success' => true ] );
	}

	public function getGenerateCode()
	{
		$str = mt_rand( 1000000000000000, 9999999999999999 );
		
		if ( AbuseReport::whereCode( $str )->first() )
		{
			return $this->getGenerateCode();
		}
		
		return response()->json( array( 'code' => $str ) );
	}

	public function postRemoteUpload(Request $request)
	{
		// uc = User Encypted Code

		if( $request->hasFile('file') && $request->has('uc') )
		{
			$curlName = array(); 

			$file = $request->file('file');

			$name = $file->getClientOriginalName();

			$ext = $file->getClientOriginalExtension();

			$filename = md5( uniqid() . date('Y-m-d his') . $name ) . '.' . $ext;

			$filePath = public_path() .'/uploads/tmp/' . $filename;

			$file->move( public_path() .'/uploads/tmp/', $filename );

			$curlName = array(
				'user_id'   => $request->get('uc'),
				'filename'	=> pathinfo($_FILES['file']['name'])['filename'],
				'user_ip'	=> Request::getClientIp(),
				'file'		=> '@' . $filePath
			);

			$request = curl_init('http://fs.filespace.io/user-upload');
			//$request = curl_init('http://localhost/test/fserver/tsk');
			
			curl_setopt($request, CURLOPT_POST, true);
			curl_setopt($request, CURLOPT_POSTFIELDS, $curlName);
			curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
			$exe = curl_exec($request);
			if( curl_errno($request) ) {
				print_R( curl_error($request) );
			}
			curl_close($request);

			File::delete($filePath);
				
			return response()->json( json_decode($exe) );
			
		}

		

		die();

	}
}
