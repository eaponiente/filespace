<?php

namespace App\Http\Controllers\Front\Folders;

use Auth;
use App\Models\FileFolders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = '')
    {
    	$querystring = '';

    	if( $id != '' && $folder = FileFolders::find($id) )
    	{
    		$querystring = '?folder_id=' . $folder->id;
    	}

        return view('front.registered.folders.index', compact('querystring'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('front.registered.folders.crud');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        	'folder_name' => 'required|unique:chs_file_folders,folder_name,NULL,id,user_id,' . Auth::id()
        ], [
        	'folder_name.unique' => 'Folder name already exist'
        ]);

        Auth::user()->filefolders()->insert([
        	'folder_name' => $request->folder_name,
        	'date_created' => date('Y-m-d H:i:s')
        ]);	

        return redirect()->back()->with('message', 'Folder successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$edit = FileFolders::find($id);

        return view('front.registered.folders.crud', compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$edit = FileFolders::find($id);

        $this->validate($request, [
        	'folder_name' => 'required|unique:chs_file_folders,folder_name,NULL,id,user_id,' . Auth::id()
        ], [
        	'folder_name.unique' => 'Folder name already exist'
        ]);

        $edit->update($request->only(['folder_name']));

        return redirect()->back()->with('message', 'Folder successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $folder = FileFolders::find($id);

        if( $folder ) {
        	$folder->delete();
        }

        return redirect()->route('folders.index')->with('message', 'Folder successfully deleted');
    }

    public function listings()
    {
    	
    	$get['search'] = (isset($_GET['sSearch']) ? $_GET['sSearch'] : ''); 
    	$get['folder_id'] = isset($_GET['folder_id']) ? $_GET['folder_id'] : '';

    	$where = FileFolders::withCount('fileuploads')->where('user_id', Auth::id())->where(function($q) use($get){
    		if( $get['search'] != '' ) {
    			$q->where('folder_name', 'LIKE', "%{$get['search']}%");
    		}
    	});

		$iTotalRecords =  $where->count();
		$iDisplayLength = intval($_GET['iDisplayLength']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart =  intval($_GET['iDisplayStart']);
		$sEcho = intval($_GET['sEcho']);

		$recs = $where->take( $iDisplayLength )->skip( $iDisplayStart )->orderBy('date_created', 'DESC')->get();

		
		$records = array();
		$records["aaData"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;

		foreach($recs as $rows){
			
			$action = '<a title="Upload" href="' . route( 'upload_to_folder', $rows[ 'id' ]) .'"><img src="img/icons/action-upload.png"></a>&nbsp;';
			$action .= '<a title="Edit" href="' . route('folders.edit', [$rows[ 'id' ]] ) .'"><img src="img/icons/action-edit.png"></a>&nbsp;';
			$action .= '<a title="Remove" data-delete-confirm="" href="' . url( 'folders/delete/' . $rows[ 'id' ] ) .'" data-delete-file="'. $rows[ 'id' ] .'"><img src="img/icons/action-delete.png"></a>';
			$action .= delete_method(route('folders.destroy', [$rows->id]), '', false);
			$row = array();
			
			$row[] = '<input type="checkbox" name="file[selected][]" value="'. $rows[ 'id' ] .'" class="all" />';
			$row[] = '<a title="'.$rows[ 'folder_name' ].'" href="' . route( 'folder', $rows[ 'id' ] ) .'">'.$rows[ 'folder_name' ].'</a>';
			$row[] = $rows->fileuploads_count;
			$row[] = $rows->date_created;
			$row[] = $action;

			
			$records["aaData"][] = $row;
			
		} 
		
		$records["sEcho"] = $sEcho;
		$records["iTotalRecords"] = $iTotalRecords;
		$records["iTotalDisplayRecords"] = $iTotalRecords;
		  
		 return json_encode($records);
    }
}
