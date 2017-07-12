<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
    	$setting = Settings::first();


    	return view('admin.settings.index', compact('setting'));
    }

    public function edit(Request $request)
    {
    	$settings = Settings::first();

    	if( $request->method() === 'POST' )
    	{
    		$data = $request->get('settings');
		
			$validator = Validator::make($data, [
				'registered_user_storage'			=> array( 'required', 'integer' ),
				'premium_user_storage'				=> array( 'required', 'integer' ),
				'free_user_max_download_speed'		=> array( 'required', 'integer' ),
				'register_user_max_download_speed'	=> array( 'required', 'integer' ),
				'premium_user_max_download_speed'	=> array( 'required', 'integer' ),
				'free_user_download_interval'		=> array( 'required', 'integer' ),
				'register_user_download_interval'	=> array( 'required', 'integer' ),
				'free_users_delay'					=> array( 'required', 'integer' ),
				'register_users_delay'				=> array( 'required', 'integer' )
			]);


			$data[ 'registered_user_storage' ] 	= $data[ 'registered_user_storage' ] * pow( 1024, 3 );
			$data[ 'premium_user_storage' ]		= $data[ 'premium_user_storage' ] * pow( 1024, 3 );

			if ($validator->fails())
			{
				return redirect()->back()->withErrors($validator)->withInput($data);
			}

			$settings->update($data);

			return redirect()->route('admin_settings_edit')->with('msg', 'Settings successfully updated.');
    	}

    	return view('admin.settings.edit', compact('settings'));
    }
}
