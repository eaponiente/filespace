<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index(Request $request)
    {
    	\DB::table('test')->insert(['name' => $request->name]);

    	return response()->json([
    		'success' => true
    	]);
    }
}
