<?php

namespace App\Http\Controllers\Front\Users;

use Auth;
use Hash;
use Mail;
use Validator;
use App\Models\User;
use App\Models\Settings;
use App\Models\TransactionsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function show()
    {
    	$user = Auth::user();

		$settings = Settings::all()->first();
		$raw_settings = Settings::all()->first();

		$payment_method = TransactionsType::find( $user->payment_method );
		$payment_method = empty( $payment_method) ? '' : $payment_method->type_name;

		$user->balance_amount = number_format( $user->balance_amount, 2);

		$custom = $settings->registered_user_storage;

		$storage = formatBytesNumber($settings->registered_user_storage);

		if( isPremium(Auth::user()) ) 
		{
			$custom = $settings->premium_user_storage;
			$storage = formatBytesNumber($settings->premium_user_storage);
		} 

		if( $user->custom_storage > 0 ) 
		{
			$custom = $user->custom_storage;
			$storage = formatBytesNumber($user->custom_storage);
		}

		return view( 'front.registered.profile.show', compact( 'user', 'title', 'settings','payment_method', 'raw_settings', 'storage', 'custom' ) );
    }

    public function checkEmail(Request $request)
    {
    	$data = $request->get('user');

		$validator = Validator::make(array(
			'email' => $data['email']
		), array(
			'email' => 'unique:chs_users,email'
		));

		return $validator->fails() ? 0 : response()->json(['success' => true]);
    }

    public function changeEmail(Request $request)
    {
    	if( $request->method() === 'POST' )
    	{
    		$this->validate($request, [
    			'user.email' => 'required|email|unique:chs_users,email,' . Auth::id()	
    		]);

    		$data = $request->get('user');

    		$user = User::find( Auth::id() );

		 	$info = array(
		 		'email' 	=> $data[ 'email' ],
		 		);

		 	Mail::send( 'pages.new.change-email-layout-message', $info, function($message) use($data)
			{
				$message->from( 'noreply@filespace.io', 'FileSpace.io System' );
			    $message->to( $data[ 'email' ] )->subject( 'Fileshare: Email Changed' );
			});

			$user->key_code_purpose = 'email_change';
			$user->key_code_expired = date( 'Y-m-d H:i:s', strtotime( '+1 days' ) );
			$user->save();

			session('_message', 'Please check your email for confirmation');

			return response()->json([ 'success' => true ]);
    	}

    	return view('front.registered.profile.change-email');
    }

    public function changePassword(Request $request)
    {
    	if( $request->method() === 'POST' )
    	{
	    	$data = $request->get( 'changepass' );
			
			$user_id = Auth::id();

			Validator::extend( 'passcheck', function($attribute, $value, $parameters ) {
			    return Hash::check( $value, Auth::user()->password ); 
			});

		 	$validator = Validator::make( $data, [
		 		'oldpassword' 	=> array( 'required', 'passcheck' ),
				'password' 		=> array( 'required', 'confirmed', 'between:6,12' )
		 	], [
		 		'passcheck' => 'Your old password was incorrect'
		 	]);

		 	if ( $validator->passes() )
			{
				$user = User::find( $user_id );
				$user->password = bcrypt( $data[ 'password' ] );
				$user->save();

				return redirect()->route( 'profile_change_password' )->with( 'message', 'Successfully updated password' );
			}

			return redirect()->back()->withErrors($validator);
    	}

    	return view('front.registered.profile.change-password');
    }


}
