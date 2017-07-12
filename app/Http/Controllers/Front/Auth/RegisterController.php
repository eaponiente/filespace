<?php

namespace App\Http\Controllers\Front\Auth;

use Auth;
use Input;
use Mail;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function register(Request $request, $affiliate_ash = '')
    {
    	if( $request->method() === 'POST' )
    	{
    		$this->validate($request, [
    			'signup.email' 	=> array('required','email','max:256','unique:chs_users,email'),
				'signup.username' => array('required', 'max:200', 'unique:chs_users,username', 'between:6,12'),
				'signup.password' => array('required', 'confirmed', 'between:6,12'),
				'signup.accept'	=> array('accepted'),
    		]);

    		$data = $request->get('signup');

    		$referral = null;

			if( ! is_null( $affiliate_ash ) )
			{
				$referral = User::whereAffiliateAsh( $affiliate_ash )->first();
			}

		 	$key_code = hash( 'sha256', uniqid( true ) . mt_rand() + ( mt_rand() / 1E8 ) );
		 	$country_code = get_country_code( $request->getClientIp(), 'Country Code' );
		 	
		 	User::create([
		 		'referral_id' => ! $referral ? 0 : $referral->id,
		 		'username' => $data['username'],
		 		'email' => $data['email'],
		 		'password' => bcrypt($data['password']),
		 		'key_code' => $key_code,
		 		'registration_ip' => $_SERVER['REMOTE_ADDR'],
		 		'registration_date' => date('Y-m-d H:i:s'),
		 		'registration_geocountry' => $country_code,
		 		'key_code_purpose' => 'registration',
		 		'key_code_expired' => date( 'Y-m-d H:i:s', strtotime( '+1 days' ) ),
		 		'user_code' => $this->generate_user_code(),
		 		'premium_expiration_date_and_time' => null
		 	]);

		 	$info = array(
		 		'username' 	=> $data['username'],
		 		'keycode' 	=> $key_code
		 	);
		
			// for beta testing
			Mail::send('emails.betatesting', $info, function($message) use($data)
			{
				$message->from('noreply@filespace.io', 'FileSpace.io System');
			    $message->to( $data['email'] , $data['username'] )->subject( 'Welcome to FileSpace.io' );
			});

			return view('front.unregistered.auth.account_created'); 
    	}
    	
    	return view('front.unregistered.auth.register', compact('affiliate_ash'));
    }

    // function used to validate in parsley
	public function checkEmail(Request $request)
	{
		$data = $request->get('signup');
		$validator = Validator::make(array('email' => $data['email']),
			array('email' =>'unique:chs_users,email'));

		return $validator->fails() ? 0 : 1;
	}
	
	// function used to validate in parsley
	public function checkUsername(Request $request)
	{
		$data = $request->get('signup');

		$validator = Validator::make(array('username' => $data['username']),
			array('username' =>'unique:chs_users,username'));
		
		if($validator->fails())
		{
			return response()->json( array( 'error' => 'Username is already taken.' ) );
		}
		else
		{
			return response()->json( array( 'success' => 'Yahoooo.' ) );
		}
	}

	private function generate_user_code()
	{
		$str = strtolower(str_random(4));

		if( User::whereUserCode( $str )->first() )
		{
			return $this->generate_user_code();
		}

		return $str;
	}
}
