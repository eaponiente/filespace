<?php

namespace App\Http\Controllers\Front\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VouchersController extends Controller
{
    public function validate(Request $request)
    {
    	return view('front.registered.vouchers.validate');
    }
}
