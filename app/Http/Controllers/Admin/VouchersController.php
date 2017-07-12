<?php

namespace App\Http\Controllers\Admin;

use App\Models\Vouchers;
use App\Library\Datatables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VouchersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.vouchers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vouchers.crud');
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
            'qty' =>' required|integer',
            'premium_days' => 'required|integer'
        ]);

        $output = 'Successfully added ' . $request->qty . ' vouchers of ' . $request->premium_days . ' days';

        $output .= '<ul class="unstyled">';

        for ($i=0; $i < $request->qty; $i++) 
        { 
            $voucher = Vouchers::create([
                'generation_datetime' => date('Y-m-d H:i:s'),
                'premium_days' => $request->premium_days,
                'is_used' => false,
                'code' => '',
                'is_generated_by' => 'Admin',
                'pin' => 0
            ]);

            $id_length = (int) strlen($voucher->id);

            $length = 12 - $id_length;

            $code = $voucher->id . $this->generate( $length );

            $voucher->update([
                'code' => $code,
            ]);

            $output .= '<li>'. $code . '</li>';
        }

        $output .= '</ul>';

        return redirect()->route('admin.vouchers.index')->with('msg', $output);
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
        $voucher = Vouchers::find($id);

        if( $voucher )
        {
            $voucher->delete();

            return redirect()->route('admin.vouchers.index')->with('fail', "Voucher {$voucher->code} deleted");
        }
    }

    public function listings()
    {
        $table = Datatables::create(new Vouchers, $_GET, [
            'id', 
            'DESC'
        ]);

        $table['output']['data'] = [];

        foreach ($table['result'] as $key => $value) 
        {
            $action = delete_method( route('admin.vouchers.destroy', [$value->id]) );

            $row = array();
            $row[] = $value->code;
            $row[] = $value->premium_days;
            $row[] = $value->is_generated_by;
            $row[] = $value->generation_datetime;
            $row[] = $value->used_user_id;
            $row[] = $value->consumed_datetime;
            $row[] = $action;


            $table['output']['data'][] = $row;
        }

        return Datatables::generateJSON($table['output']);
    }

    /**
     * Generate 12 characters length for the voucher code 
     * Combination of numbers and letters all capital
     * @return string
     */
    private function generate($length = 12)
    {
        $code = strtoupper(str_random($length));

        if( Vouchers::whereCode($code)->first() )
        {
            return $this->generate($length);
        }

        return $code;
    }
}
