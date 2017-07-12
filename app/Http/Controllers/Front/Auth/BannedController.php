<?php

namespace App\Http\Controllers\Front\Auth;

use App\Models\IpBan;
use App\Models\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannedController extends Controller
{
    public function banned(Request $request)
    {
    	$data = geoip($request->getClientIp());

    	// check first if user country is banned
		$country = Countries::whereCode( $data['iso_code'] )->whereIsBanned(1)->first();

		if( $country )
		{
			$message = 'Sorry, you are not allowed<br /> to access our services from '. $country->full_name;

			return view('front.banned.index', compact('country', 'message'));
		} 

		// check if country allowed but ip is banned
		$ipban = IpBan::whereIp( $data['ip'] )->first();

		if( $ipban )
		{
			$message = 'Sorry, the ip '. $data['ip'] . ' is not allowed <br />  to access our website';

			return view('front.banned.index', compact('country', 'message'));
		}

        if( ! $country && ! $ipban ) return redirect()->to('/');

    }
}
