<?php

namespace App\Http\Controllers\Front\Folders;

use Auth;
use App\Models\FileFolders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActionController extends Controller
{
    public function checkFolderName()
	{
		$json = array();
		$json[ 'success' ] = false;
		
		if ( isset( $_POST[ 'folder_name' ] ) )
		{

			$chs = FileFolders::where('folder_name', $_POST['folder_name'])->where('user_id', Auth::id() )->get();
			
			if ( $chs->count() == 0 )
			{
				$json[ 'success' ] = true;
			}
		}
		
		return response()->json( $json );
	}
}
