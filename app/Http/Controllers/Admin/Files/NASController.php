<?php

namespace App\Http\Controllers\Admin\Files;

use App\Library\Datatables;
use App\Models\Filenas;
use App\Models\FilenasStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NASController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.filenas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = FilenasStatus::all();

        return view('admin.filenas.crud', compact('status'));
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
            'serverLabel' => 'required',
            'statusId' => 'required',
            'storagePath' => 'required',
            'total_space' => 'required',
            'serverType' => 'required'
        ]);

        $data = $request->except(['_token', '_method']);

        Filenas::create($data);

        return redirect()->route('admin.filenas.index')->with('msg', "File NAS created");
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
        $edit = Filenas::find($id);

        $status = FilenasStatus::all();

        return view('admin.filenas.crud', compact('edit', 'status'));
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
        $this->validate($request, [
            'serverLabel' => 'required',
            'statusId' => 'required',
            'storagePath' => 'required',
            'total_space' => 'required',
            'serverType' => 'required'
        ]);

        $edit = Filenas::find($id);

        $data = $request->except(['_token', '_method']);

        $edit->update($data);

        return redirect()->route('admin.filenas.index')->with('msg', "File NAS created");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listings()
    {
        $table = Datatables::create(new Filenas, $_GET, [
            'id', 
            'DESC'
        ]);

        $table['output']['data'] = [];

        foreach ($table['result'] as $key => $value) 
        {
            $action = '<a href="' . route('admin.filenas.edit', [$value->id]) . '" class="btn btn-xs green">Edit</a>';
            $action .= delete_method( route('admin.ipbanned.destroy', [$value->id]), 'form-inline' );

            $percent = $value['total_space'] > $value['space_used'] ? ( ($value['space_used'] * 100) / $value['total_space'] ) : 0;

            $row = array();
            $row[] = $value->serverLabel;
            $row[] = $value->serverType;
            $row[] = $value->storagePath;
            $row[] = $this->formatBytes( $value->space_used ) . ' ('. round($percent) .'% )' ;
            $row[] = $value['total_space'] > 0 ? $this->formatBytes( $value['total_space'] ) : 0 ;
            $row[] = $value['files'];
            $row[] = $value->status ? $value->status->label : '';
            $row[] = $action;


            $table['output']['data'][] = $row;
        }

        return Datatables::generateJSON($table['output']);
    }

    function formatBytes($size, $precision = 2)
    {
        $base = log($size) / log(1024);
        $suffixes = array('', 'k', 'M', 'G', 'T');   

        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    }
}
