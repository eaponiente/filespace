<?php

namespace App\Http\Controllers;

use App\Models\Filenas;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        DB::table('test')->insert([
            'name' => $request->message
        ]);
    }

	public function test(Request $request)
	{
		$server = Filenas::find(2);

		$file = $request->file('img');
		

		$source = [
			'realpath' => $file->getRealPath(),
			'type' => $file->getMimeType(),
			'ext' => $file->getClientOriginalExtension()
		];


		$result = $this->upload_remote_direct($source, ['filename' => '', 'extension' => ''], $server, 'uploads');

		echo $result;
	}

    private function upload_remote_direct( $source, $file_real, $server, $fp_dir )
	{
		// initialise the curl request
		//$request 	= curl_init( $server[ 'fileServerDomainName' ] . 'test/fileshare/' . $server[ 'scriptPath' ] );
		$request = curl_init('http://localhost/filespace_fs/trunk/public/api/do-upload');

		$header = array('Content-Type: multipart/form-data');
		$POST_DATA = [
			//'accessAuth'	=> Config::get('constants.direct_remote_auth_access'),
			'storagePath' 	=> str_finish($server[ 'storagePath' ], '/'),
			'directory' 	=> $fp_dir,
			'filename'		=> $file_real[ 'filename' ],
			'extension'		=> $file_real[ 'extension' ],
			'file' 			=> curl_file_create($source['realpath'], $source['type'], mt_rand(1,100) . '.' . $source['ext'] )
		];
		
		// send a file
		@curl_setopt( $request, CURLOPT_POST, true );
		@curl_setopt( $request, CURLOPT_HTTPHEADER, $header);
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
}
