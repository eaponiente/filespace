<?php

namespace App\Http\Controllers\Front;

use Auth;
use App\Models\Filenas;
use App\Models\FileFolders;
use App\Models\Fileserver;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home( $upload_to_folder = null )
	{
		$folder = null;

		if( ! is_null( $upload_to_folder ) )
		{
			$folder = FileFolders::where( 'user_id', Auth::id() )->find( $upload_to_folder );

			if( count( $folder->toArray() ) == 0 )
			{
				$folder = (array) $folder;
			}

		}

		$server = Filenas::where('serverType', 'direct')->orderByRaw('RAND()')->first();

		$disksize = 0;

		if( Auth::check() )
		{
			if( Auth::user()->custom_storage > 0 )
			{
				$disksize = Auth::user()->get()->custom_storage;
			}
			else
			{
				$setting = Settings::first();
				$disksize = Auth::user()->premium_expiration_date_and_time > date('Y-m-d h:i:s') ? $setting->premium_user_storage : $setting->registered_user_storage;
			}
		}

		$server_off = ! Fileserver::check_fileservers() || ! Fileserver::check_local_fileserver_on();

		$random_server = $server;

	    $randServer = str_finish($server->fileServerDomainName, '/') . $server->scriptPath;

		return view('front.upload.index', compact( 'server_off', 'folder', 'server', 'disksize', 'randServer', 'random_server'));
	}
}
