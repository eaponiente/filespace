<?php

namespace App\Http\Controllers\Admin\Users;

use App\Models\User;
use App\Models\Settings;
use App\Library\Datatables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.crud');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $user = User::whereUsername($username)->first();
        
        if( ! $user )
            return redirect()->route('admin.users.index');

        $settings = Settings::first();

        return view('admin.users.show', compact('user', 'settings'));
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
        $user = User::find($id);

        if( $user ) $user->delete();

        return redirect()->back()->with('msg', 'User ' . $user->username . ' has been deleted');
    }

    public function listings()
    {
        $table = Datatables::create(User::withCount('fileuploads'), $_GET, [
            'username', 
            'DESC'
        ]);

        $table['output']['data'] = [];

        foreach ($table['result'] as $key => $value) 
        {
            $action = '<a href="' . route('admin.users.show', [$value->username]) .'" class="btn btn-success btn-xs">Details</a>';
            $action .= '<a onclick="addFreeDays(this);" data-url="'.route('add_freedays', [$value->id]).'" class="btn btn-xs blue" href="javascript:;" data-name="'.$value->username.'">Add free days</a>';
            $action .= delete_method( route('admin.users.destroy', [$value->id]) );

            $row = array();
            $row[] = $value->username;
            $row[] = $value->country ? $value->country->full_name : '';
            $row[] = $value->email;
            $row[] = array_get(config('constants.users.status'), $value->status);
            $row[] = $value->is_affiliate;
            $row[] = number_format( $value->balance_amount, 2 );
            $row[] = $value->fileuploads_count;
            $row[] = formatBytes($value->custom_storage);
            $row[] = $value->registration_date->format('m/d/Y h:i:s');
            $row[] = $value->last_visited->format('m/d/Y h:i:s');
            $row[] = $action;


            $table['output']['data'][] = $row;
        }

        return Datatables::generateJSON($table['output']);
    }
}
