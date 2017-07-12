<?php

namespace App\Http\Controllers\Admin;

use App\Models\Resellers;
use App\Models\ResellersTransactions;
use App\Library\Datatables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResellersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.resellers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.resellers.crud');
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
            'username' => 'required|unique:chs_resellers,username',
            'email' => 'required|email|unique:chs_resellers,email',
            'password' => 'required|confirmed',
            'discount_rate' => 'required|integer'
        ]);

        $data = $request->only(['username', 'email', 'password', 'status', 'discount_rate']);

        $data['password'] = bcrypt($data['password']);

        Resellers::create($data);

        return redirect()->route('admin.resellers.index')->with('msg', 'Reseller added');
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
        $edit = Resellers::find($id);

        return view('admin.resellers.crud', compact('edit'));
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
        $edit = Resellers::find($id);

        $this->validate($request, [
            'username' => 'required|unique:chs_resellers,username,' . $edit->id,
            'email' => 'required|unique:chs_resellers,email,' . $edit->id,
            'discount_rate' => 'required|integer',
            'password' => 'sometimes|confirmed'
        ]);

        $data = $request->only(['username', 'email', 'password', 'status', 'discount_rate']);

        $data['password'] = $request->has('password') ? bcrypt($request->password) : $edit->password;

        $edit->update($data);

        return redirect()->route('admin.resellers.index')->with('msg', "Reseller {$edit->username} updated");
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
        $table = Datatables::create(new Resellers, $_GET, [
            'reg_datetime', 
            'DESC'
        ]);

        $table['output']['data'] = [];

        foreach ($table['result'] as $key => $value) 
        {
            $action = '<a href="' . route('admin.resellers.edit', [$value->id]) . '" class="btn btn-xs green">Edit</a>';
            $action .= '<a href="'. route('reseller_add_balance', [$value->id]) .'" class="btn btn-xs blue">Add Balance</a>';

            $row = array();
            $row[] = $value->username;
            $row[] = $value->discount_rate;
            $row[] = $value->reg_datetime;
            $row[] = $value->last_login_datetime;
            $row[] = $value->last_login_ip . '(' . $value->last_login_geocountry . ')';
            $row[] = $value->balance;
            $row[] = $action;


            $table['output']['data'][] = $row;
        }

        return Datatables::generateJSON($table['output']);
    }

    public function addBalance(Request $request, $id)
    {
        $edit = Resellers::find($id);

        if( $request->method() === 'POST' )
        {
            $this->validate($request, [
                'amount' => 'required|integer'
            ]);

            $data = $request->all();

            $previous_balance = $edit->balance;

            $percentage = ($edit->discount_rate / 100) * $data['amount'];
            $total_amount = $data['amount'] + $percentage;

            $edit->balance = $edit->balance + $total_amount;
            $edit->save(); 

            $data['transferred_amount'] = $data['amount'];
            $data['type'] = 'funding';
            $data['amount'] = $total_amount;
            $data['previous_balance'] = $previous_balance;
            $data['new_balance'] = $edit->balance;
            $data['voucher_id'] = 0;
            
            ResellersTransactions::create($data);

            return redirect()->route('admin.resellers.index')->with('msg', "Added Balance on reseller {$edit->username}");
        }

        return view('admin.resellers.addbalance', compact('edit'));
    }
}
