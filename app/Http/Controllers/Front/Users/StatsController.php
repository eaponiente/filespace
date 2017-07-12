<?php

namespace App\Http\Controllers\Front\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatsController extends Controller
{
    public function index()
    {
    	return view('front.registered.stats.index');
    }
}
