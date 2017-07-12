<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function login(Request $request)
    {
    	if( $request->method() === 'POST' )
    	{
    		Auth::guard('admin')->attempt($request->except(['_token']));

    		if( Auth::guard('admin')->check() )
    		{
    			return redirect()->route('admin_login');
    		}
    	}

    	if( Auth::guard('admin')->check() )
    	{
    		return view('admin.dashboard.index');
    	}

    	return view('admin.login.index');
    }

    public function logout()
    {
    	Auth::guard('admin')->logout();

    	return redirect()->route('admin_login');
    }
}
