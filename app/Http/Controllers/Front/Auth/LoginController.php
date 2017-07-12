<?php

namespace App\Http\Controllers\Front\Auth;

use Auth;
use App\Models\User;
use App\Models\Countries;
use App\Models\IpBan;
use App\Traits\LoginTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
	use LoginTrait;

    public function login(Request $request)
    {
    	if( $request->method() === 'POST' )
    	{
			$login = $request->get('login');

			$user = User::where('username', $login['username'] )->first();

			// check if ip of user banned
			if( $this->isIpBanned( $request->getClientIp() ) ) return redirect()->to('banned-ip');

			// check if country of user is banned
			if( $this->isCountryBanned() ) return redirect()->to('banned-country');

			// check if user exists
			if( ! $user ) return redirect()->back()->with('error', 'User not found');

			// check if user is banned
			if( $user->status == 2 ) return redirect()->back()->with('error', 'Sorry, your account was banned by the Administrator');

			// check if user is pending
			if( $user->status == 3 ) return redirect()->back()->with('error', 'Sorry, your account is still pending');

			if ( count( $user ) > 0 )
			{
				Auth::attempt(
					array(
					'username'=> $login[ 'username' ],
					'password'=> $login[ 'password' ],
					'status'  => '1'
				), isset($login['remember']) == 'yes' ? true : false);


				if(Auth::check())
				{
				    $login_success = true;

				    $info = User::find($user->id);
				    $info->last_visited = date( 'Y-m-d H:i:s' );
				    $info->save();

				    return redirect()->to( '/' );
				} 

			}

    	}

    	return view('front.unregistered.auth.login');
    }

    public function logout()
    {
    	Auth::logout();

    	return redirect()->to('/');
    }

    
    
}
