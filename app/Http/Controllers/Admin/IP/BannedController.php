<?php

namespace App\Http\Controllers\Admin\IP;
use App\Models\IpBan;
use App\Library\Datatables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.ipban.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ipban.crud');
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
            'ip' => 'unique:chs_ip_ban,ip|ip|required'
        ]);
        
        $request->merge(['datetime_added' => date('Y-m-d H:i:s')]);
        
        IpBan::create($request->all());

        return redirect()->route('admin.ipbanned.index')->with('msg', 'IP added successfully.');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ip = IpBan::find($id);

        if( $ip )
        {
            $ip->delete();

            return redirect()->route('admin.ipbanned.index')->with('msg', 'IP ' . $ip->ip . ' is now removed from ban.');
        }

        return redirect()->route('admin.ipbanned.index')->with('fail', 'Not found');
    }

    public function listings()
    {
        $table = Datatables::create(new IpBan, $_GET, [
            'id', 
            'DESC'
        ]);

        $table['output']['data'] = [];

        foreach ($table['result'] as $key => $value) 
        {
            $action = delete_method( route('admin.ipbanned.destroy', [$value->id]) );

            $row = array();
            $row[] = $value->ip;
            $row[] = $value->datetime_added->format('Y-m-d H:i:s');
            $row[] = $action;


            $table['output']['data'][] = $row;
        }

        return Datatables::generateJSON($table['output']);
    }
}
