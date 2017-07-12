<?php

namespace App\Http\Controllers\Front\Files;

use Session;
use App\Models\UserStats;
use App\Models\FileUploads;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadCompleteController extends Controller
{
    public function uploadSuccess()
	{
		/*$session_json 	= Session::get( 'upload_success' );
		$upload_from 	= Session::get( 'upload_from' ) === null ? 'local' : Session::get( 'upload_from' );
		
		if ( is_null( $session_json ) )
		{
			$raw = isset( $_GET[ 'raw' ] ) ? $_GET[ 'raw' ] : null;
			
			if ( is_null( $raw ) )
			{
				return redirect()->to( '/' );
			}
			
			$json = json_decode( $raw );
			
			return redirect()->to( 'upload/upload-success' )->with( 'upload_success', $json );
		}
		else
		{*/
			$files 				= json_decode($_GET['raw']);//$session_json;
			$successful_files 	= 0;
			$total_filesize		= 0;
			$upload_from = 'local';
			UserStats::stats('uploads');
			
			foreach ( $files as $file )
			{
				$file_actual = FileUploads::find($file->file_id);

				if( $file_actual )
				{
					$tmp_size = $upload_from == 'local' ? $file->size : $file->size;

					if ( $file->success )
					{
						$successful_files++;
						$total_filesize += $file_actual->filesize_bytes;
					}
				}

				
			}

			$formatted_data = formatBytes( $total_filesize, 2 );
			
			$str = count( $files ) > 1 ? ' files' : ' file';

			return view('front.upload.success', compact( 'files', 'successful_files', 'formatted_data', 'total_filesize' ) );
		//}
	}
}
