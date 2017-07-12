<?php

namespace App\Http\Controllers\Front\Resellers;

use Auth;
use App\Models\Resellers;
use App\Models\Packages;
use App\Traits\LoginTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
	use LoginTrait;

	public function login(Request $request)
	{
		if( Auth::guard('resellers')->check() )
		{
			$packages = Packages::all();

			return view('front.resellers.vouchers', compact('packages'));
		}

    	if( $request->method() === 'POST' )
    	{
			$login = $request->get('login');


			$user = Resellers::where('username', $login['username'] )->first();

			// check if ip of user banned
			if( $this->isIpBanned( $request->getClientIp() ) ) return redirect()->to('banned-ip');

			// check if country of user is banned
			if( $this->isCountryBanned() ) return redirect()->to('banned-country');

			// check if user exists
			if( ! $user ) return redirect()->back()->with('error', 'User not found');

			// check if user status = disabled
			if( $user->status == 'disabled' ) return redirect()->back()->with('error', 'Sorry, your account is still disabled');

			if ( count( $user ) > 0 )
			{
				Auth::guard('resellers')->attempt(
					array(
					'username'=> $login[ 'username' ],
					'password'=> $login[ 'password' ]
				));


				if(Auth::guard('resellers')->check())
				{
				    $login_success = true;

				    $country_code = function_exists( 'geoip_country_code_by_name' ) ? @geoip_country_code_by_name( $_SERVER[ 'REMOTE_ADDR' ] ) : '';
				    $user->last_login_ip = Request::getClientIp();
					$user->last_login_geocountry = $country_code;
				    $user->last_login_datetime = date( 'Y-m-d H:i:s' );
				    $user->save();

				    return redirect()->to( 'resellers' );
				} 

			}

    	}


    	return view('front.unregistered.auth.login');
    }

    public function logout()
    {
    	Auth::guard('resellers')->logout();

    	return redirect()->to('/');
    }
}
