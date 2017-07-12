<?php

namespace App\Http\Controllers\Admin\Files;

use App\Library\Datatables;
use App\Models\Fileserver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.fileserver.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.fileserver.crud');
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
            'name' => 'required',
            'ip' => 'required|ip|unique:chs_fileserver,ip'
        ]);

        $request->merge(['status' => 0]);

        $server = Fileserver::create($request->only(['name', 'ip', 'status']));

        return redirect()->route('admin.fileserver.index')->with('msg', "File Server {$server->name} created");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Fileserver::find($id);

        return view('admin.fileserver.crud', compact('edit'));
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
        $edit = Fileserver::find($id);

        $this->validate($request, [
            'name' => 'required',
            'ip' => 'required|ip|unique:chs_fileserver,ip,'. $edit->id
        ]);

        $edit->update($request->only([
            'name', 
            'ip'
        ]));

        return redirect()->route('admin.fileserver.index')->with('msg', "File Server {$edit->name} updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $server = Fileserver::find($id);

        if( $server )
        {
            $server->delete();

            return redirect()->route('admin.fileserver.index')->with('fail', "File Server {$server->name} deleted");
        }
    }

    public function listings()
    {
        $table = Datatables::create(new Fileserver, $_GET, [
            'id', 
            'DESC'
        ]);

        $table['output']['data'] = [];

        foreach ($table['result'] as $key => $value) 
        {
            $action = '<a href="' . route('admin.fileserver.edit', [$value->id]) . '" class="btn btn-xs green">Edit</a>';
            $action .= delete_method( route('admin.fileserver.destroy', [$value->id]) );

            $row = array();
            $row[] = $value->name;
            $row[] = $value->ip;
            $row[] = $value->status;
            $row[] = $action;


            $table['output']['data'][] = $row;
        }

        return Datatables::generateJSON($table['output']);
    }
}
