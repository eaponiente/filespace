<?php

namespace App\Http\Controllers\Admin\Countries;

use App\Library\Datatables;
use App\Models\Countries;
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
        return view('admin.countriesban.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Countries::whereIsBanned(0)->orderBy('full_name', 'ASC')->get();

        return view('admin.countriesban.crud', compact('countries'));
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
            'id' => 'required'
        ]);
        
        $country = Countries::find($request->id);
        
        $country->update([
            'is_banned' => 1,
            'datetime_banned' => date('Y-m-d H:i:s')
        ]);  

        return redirect()->route('admin.countriesban.index')->with('msg', 'Country banned successfully.');
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
        $country = Countries::find($id);

        if( $country )
        {
            $country->update([
                'is_banned' => 0,
                'datetime_banned' => null
            ]);

            return redirect()->route('admin.countriesban.index')->with('msg', 'Country is now removed from ban.');
        }

        return redirect()->route('admin.countriesban.index')->with('fail', 'Not found');
    }

    public function listings()
    {
        $table = Datatables::create(Countries::whereIsBanned(1), $_GET, [
            'full_name', 
            'ASC'
        ]);

        $table['output']['data'] = [];

        foreach ($table['result'] as $key => $value) 
        {
            $action = delete_method( route('admin.countriesban.destroy', [$value->id]) );

            $row = array();
            $row[] = $value->full_name;
            $row[] = $value->datetime_banned->format('Y-m-d H:i:s');
            $row[] = $action;


            $table['output']['data'][] = $row;
        }

        return Datatables::generateJSON($table['output']);
    }
}
