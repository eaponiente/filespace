<?php

namespace App\Http\Controllers\Front\Files;

use Auth;
use Validator;
use App\Models\FileUploads;
use App\Models\FileFolders;
use App\Models\WebsiteCodes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagerController extends Controller
{
    public function index($folder_id = '')
    {
    	$querystring = '';

    	$folder = null;

    	if( $folder_id != '' && $folder = FileFolders::find($folder_id) )
    	{
    		$querystring = '?folder_id=' . $folder->id;
    	}

		$folders = Auth::user()->filefolders()->orderBy('folder_name', 'ASC')->get();

		return view( 'front.registered.files.index', compact( 'files', 'folders', 'folder', 'folder_id', 'querystring' ) );
    }

    public function edit(Request $request, $id)
    {
    	$file = FileUploads::find( $id );

    	if( $request->method() === 'POST' )
    	{
			$data = $request->get('file');
			$data[ 'is_public' ] = isset( $data[ 'is_public' ] ) ? 1 : 0;
			$data[ 'is_premium_only' ] = isset( $data[ 'is_premium_only' ] ) ? 1 : 0;

			$message = array(
				'between' => 'Password must be between 4 and 6 chars'
				);

			$validator = Validator::make($data, [
				'password' => 'between:4,6'
			], $message );

			if ($validator->fails())
			{
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$file->update($data);

			return redirect()->route('user_file_edit', [$file->id] )->with('message', 'File successfully updated.');
    	}
    	
    	return view('front.registered.files.edit', compact('file'));
    }

    public function listings()
	{
		$files = new FileUploads;
		$search = (isset($_GET['sSearch']) ? $_GET['sSearch'] : ''); 
		$folder_id = (isset($_GET['folder_id']) ? $_GET['folder_id'] : null);
		$sType = (isset($_GET['sSortDir_0']) ? $_GET['sSortDir_0'] : 'DESC');

		$iTotalRecords =  $files->get_max_pages($search, Auth::id(), $folder_id );
		$iDisplayLength = intval($_GET['iDisplayLength']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart =  intval($_GET['iDisplayStart']);
		$sEcho = intval($_GET['sEcho']);

		$recs = $files->ShowFiles($iDisplayStart, $iDisplayLength, $search, $_GET['iSortCol_0'], $sType, Auth::id(), $folder_id);

		
		$records = array();
		$records["aaData"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;

		foreach($recs as $rows){
			   
			$file = FileUploads::find( $rows->id );

            $sitecode = WebsiteCodes::where( 'user id', 0)->first();

            $file->krypt_id = syferEncode($rows->id, $sitecode->code);


            $title = $rows[ 'title' ] . '.' . $rows[ 'file_ext' ];
            $delete_hash = $rows['delete_hash'];
			$action = "";
			$action .= '<a title="Show Links" href="#" data-toggle="modal" data-size="('.formatBytes( $rows[ 'filesize_bytes' ], 2 ).')" data-target="#myModal" data-title="' . $title . '" data-btn="share" data-hash="'.$rows['delete_hash'].'" data-id="' . $file->id . '"><img src="'. url('img/icons/action-link.png') .'"></a>';
			
			$action .= '<a title="Show Reference Links" href="#" data-toggle="modal" data-size="('.formatBytes( $rows[ 'filesize_bytes' ], 2 ).')" data-target="#modalRefLink" data-title="' . $title . '" data-btn="reflink" data-id="' . $rows->id . '"><img src="'. url('img/icons/ref-icon.png') .'"></a>';
			$action .= '<a title="Edit File" href="' . route('user_file_edit', [$rows->id]) . '"><img src="' . url('img/icons/action-edit.png') .'"></a>';
			$action .= '<a title="Delete" href="#" data-delete-file="'. $rows[ 'id' ] .'"><img src="' . url('img/icons/action-delete.png') .'"></a>';
			$row = array();
			
			$row[] = '<input type="checkbox" name="file[selected][]" value="'. $rows[ 'id' ] .'" class="all" />';
			$row[] = $rows[ 'title' ] . '.' . $rows[ 'file_ext' ];
			$row[] = formatBytes( $rows[ 'filesize_bytes' ], 2 );
			$row[] = preg_replace( '/\s/', '<br>', $rows[ 'datetime_uploaded' ] );
			$row[] = empty( $rows[ 'last_download'] ) || is_null( $rows[ 'last_download'] ) ? '---' : preg_replace( '/\s/', '<br>', $rows[ 'last_download' ] );
			$row[] = $rows[ 'is_public' ] == 1 ? '<a href="'. url( 'files/status-public/0' ) .'" class="jkl" data-file-id="'. $rows[ 'id' ] .'"><img src="' . url('img/icons/success.png') .'"></a>' : '<a href="'. url( 'files/status-public/1' ) .'" class="jkl" data-file-id="'. $rows[ 'id' ] .'"><img src="' . url('img/icons/error.png') .' "></a>';
			$row[] = ( $rows[ 'is_premium_only' ] == 1 ? '<a href="'. url( 'files/status-premium/0' ) .'" class="jkl" data-file-id="'. $rows[ 'id' ] .'"><img src="' . url('img/icons/success.png') .'"></a>' : '<a href="'. url( 'files/status-premium/1' ) .'" class="jkl" data-file-id="'. $rows[ 'id' ] .'"><img src="' . url('img/icons/error.png') .'"></a>' );
			$row[] = empty( $rows[ 'password' ] ) ? '<img src="' . url('img/icons/error.png') .'">' : $rows[ 'password' ];
			$row[] = $action;

			
			// $row["DT_RowId"] = 'row_' . $rows['id'];
			// $row["DT_RowClass"] = (($rows["with_errors"] == 1) ? 'alert alert-danger' : '');
			
			$records["aaData"][] = $row;
			
		} 
		
		$records["sEcho"] = $sEcho;
		$records["iTotalRecords"] = $iTotalRecords;
		$records["iTotalDisplayRecords"] = $iTotalRecords;

		return json_encode($records);
	}
}
