<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('banned', 'Front\Auth\BannedController@banned')->name('banned');

Route::group([ 'middleware' => 'firewall' ], function() {
	Route::get('/', 'Front\HomeController@home');

	Route::group(['prefix' => 'upload'], function() {
		Route::post('do-upload', 'Front\Files\UploadController@postDoUpload');
		Route::get('upload-success', 'Front\Files\UploadCompleteController@uploadSuccess')->name('upload_success');
		Route::get('folder/{id?}', 'Front\HomeController@home')->name('upload_to_folder');

	});

	Route::get('remote-upload', 'Front\HomeController@home');

	Route::group(['prefix' => 'download'], function() {
		Route::post('capcha', 'Front\Files\DownloadController@postCapcha')->name('download_capcha');
		Route::any('stream-file/{krypt}', 'Front\Files\DownloadController@getStreamFile')->name('stream_file');
	});


	
	Route::any('login', 'Front\Auth\LoginController@login')->name('user_login');
	Route::get('logout', 'Front\Auth\LoginController@logout')->name('user_logout');
	Route::any('signup', 'Front\Auth\RegisterController@register')->name('user_signup');

	Route::group(['prefix' => 'signup'], function() {
		Route::get('check-username', 'Front\Auth\RegisterController@checkUsername')->name('check_username');
		Route::get('check-email', 'Front\Auth\RegisterController@checkEmail')->name('check_email');
	});

	

	Route::resource('abuse', 'Front\Users\Abusecontroller');

	Route::group(['prefix' => 'file'], function() {
		// Download File
		Route::get('/{code}', 'Front\Files\DownloadController@fileDownload')->name('file');
		
		// Delete File
		Route::get('/delete/{code}/{hash}', 'Front\Files\ManagerController@listings')->name('file_delete');

		Route::post('check-password', 'Front\Files\DownloadController@postCheckPassword')->name('file_check_password');

		Route::post('download-boot', 'Front\Files\DownloadController@postDownloadBoot')->name('file_download_boot');
	});

	Route::group(['middleware' => 'auth.user'], function() {
		
		Route::group(['prefix' => 'profile'], function() {
			Route::get('/', 'Front\Users\ProfileController@show')->name('user_profile');
			Route::post('check-email', 'Front\Users\ProfileController@checkEmail')->name('profile_check_email');
			Route::any('change-email', 'Front\Users\ProfileController@changeEmail')->name('profile_change_email');
			Route::any('change-password', 'Front\Users\ProfileController@changePassword')->name('profile_change_password');
            Route::get('upgrade', 'Front\Users\UpgradeController@upgrade')->name('profile_upgrade');
            Route::post('upgrade/process', 'Front\Users\UpgradeController@process')->name('profile_upgrade_process');
            Route::post('upgrade/credit', 'Front\Users\UpgradeController@payment')->name('credit_card_payment');
		});

		Route::group(['prefix' => 'files'], function() {
			Route::get('/', 'Front\Files\ManagerController@index')->name('user_files');
			Route::get('listings', 'Front\Files\ManagerController@listings')->name('user_files_listings');
			Route::post('/status-public/{id}', 'Front\Files\ManagerActionsController@statusPublic')->name('set_status_public');
			Route::post('/status-premium/{id}', 'Front\Files\ManagerActionsController@statusPremium')->name('set_status_premium');
			Route::any('edit/{id}', 'Front\Files\ManagerController@edit')->name('user_file_edit');
			Route::post('move-to-folder', 'Front\Files\ManagerActionsController@moveFolder')->name('move_to_folder');
			
		});

		

		Route::group(['prefix' => 'folders'], function() {
			Route::get('listings', 'Front\Folders\ManagerController@listings')->name('user_folders_listings');
			Route::post('check', 'Front\Folders\ActionController@checkFolderName')->name('check_folder_name');
		});
		Route::resource('folders', 'Front\Folders\ManagerController');

		Route::group(['prefix' => 'referrals'], function() {
			Route::get('/', 'Front\Users\ReferralsController@index')->name('referrals');
			Route::get('listings', 'Front\Users\ReferralsController@listings')->name('referrals_listings');
		});

		Route::group(['prefix' => 'site-codes'], function() {
			Route::get('/', 'Front\Users\SitecodesController@index')->name('sitecodes');
			Route::any('checker/{code}', 'Front\Users\SitecodesController@checker')->name('sitecodes_checker');
		});



		Route::get('payments', 'Front\Users\PaymentsController@index')->name('payments');

		Route::any('payment-successful', 'Front\Users\PaymentsController@successful')->name('payment_successful');

		Route::get('stats', 'Front\Users\StatsController@index')->name('stats');

		Route::get('folder/{id}', 'Front\Files\ManagerController@index')->name('folder');

		// Set Multiple Reference link
		Route::post('multi-reference-link', 'Front\Files\ManagerActionsController@set_multi_reference_link');

		// Set Reference link
		Route::post('reference-link', 'Front\Files\ManagerActionsController@set_reference_link');

		// Set password for folders
		Route::post('set-password-folder', 'Front\Files\ManagerActionsController@post_setpassword_folder');

		// Set password for file
		Route::post('set-password', 'Front\Files\ManagerActionsController@post_setpassword');

		// Get single show link
		Route::post('single-showlink', 'Front\Files\ManagerActionsController@single_showlink');

		// Get multiple show links
		Route::post('multiple-show-links', 'Front\Files\ManagerActionsController@mass_showlinks');

		Route::post('multi-select-action', 'Front\Files\ManagerActionsController@multiSelectAction')->name('files_multi_select_action');
	});

	Route::any('resellers', 'Front\Resellers\LoginController@login')->name('reseller_login');
	Route::group(['prefix' => 'resellers', 'middleware' => 'auth.resellers'], function() {
		Route::get('logout', 'Front\Resellers\LoginController@logout')->name('reseller_logout');
		Route::get('vouchers', 'Front\Resellers\ActionController@vouchers');
		Route::post('generate-voucher', 'Front\Resellers\ActionController@generateVoucher')->name('resellers_generate_voucher');
		Route::get('profile', 'Front\Resellers\ActionController@profile');
		Route::get('listings', 'Front\Resellers\ActionController@listing')->name('resellers_vouchers_listing');
	});

	Route::any('casgwfckasgcew', 'Admin\MainController@login')->name('admin_login');
	Route::group(['prefix' => 'casgwfckasgcew', 'middleware' => 'auth.admin'], function() {
		Route::get('logout', 'Admin\MainController@logout')->name('admin_logout');

		

		Route::group(['prefix' => 'users'], function() {
			Route::post('set-custom-storage/{id}', 'Admin\Users\ExtraController@setCustomStorage')->name('set_custom_storage');
			Route::post('add-freedays/{id}', 'Admin\Users\ExtraController@addFreeDays')->name('add_freedays');
			Route::post('listings', 'Admin\Users\UserController@listings')->name('users_listings');
		});

		Route::resource('users', 'Admin\Users\UserController', [
			'names' => [
				'index' => 'admin.users.index',
				'create' => 'admin.users.create',
				'show' => 'admin.users.show',
				'edit' => 'admin.users.edit',
				'update' => 'admin.users.update',
				'destroy' => 'admin.users.destroy'
			]
		]);

		Route::post('ipbanned-listings', 'Admin\IP\BannedController@listings')->name('ipbanned_listings');
		Route::resource('ipbanned', 'Admin\IP\BannedController', [
			'names' => [
				'index' => 'admin.ipbanned.index',
				'create' => 'admin.ipbanned.create',
				'store' => 'admin.ipbanned.store',
				'edit' => 'admin.ipbanned.edit',
				'update' => 'admin.ipbanned.update',
				'destroy' => 'admin.ipbanned.destroy'
			]
		]);

		Route::post('countries-banned-listings', 'Admin\Countries\BannedController@listings')->name('countries_banned_listings');
		Route::resource('countries-banned', 'Admin\Countries\BannedController', [
			'names' => [
				'index' => 'admin.countriesban.index',
				'create' => 'admin.countriesban.create',
				'store' => 'admin.countriesban.store',
				'edit' => 'admin.countriesban.edit',
				'update' => 'admin.countriesban.update',
				'destroy' => 'admin.countriesban.destroy'
			]
		]);


		Route::post('vouchers-listings', 'Admin\VouchersController@listings')->name('vouchers_listings');
		Route::resource('vouchers', 'Admin\VouchersController', [
			'names' => [
				'index' => 'admin.vouchers.index',
				'create' => 'admin.vouchers.create',
				'store' => 'admin.vouchers.store',
				'edit' => 'admin.vouchers.edit',
				'update' => 'admin.vouchers.update',
				'destroy' => 'admin.vouchers.destroy'
			]
		]);

		Route::any('reseller-add-balance/{id}', 'Admin\ResellersController@addBalance')->name('reseller_add_balance');
		Route::post('resellers-listings', 'Admin\ResellersController@listings')->name('resellers_listings');
		Route::resource('resellers', 'Admin\ResellersController', [
			'names' => [
				'index' => 'admin.resellers.index',
				'create' => 'admin.resellers.create',
				'store' => 'admin.resellers.store',
				'edit' => 'admin.resellers.edit',
				'update' => 'admin.resellers.update',
				'destroy' => 'admin.resellers.destroy'
			]
		]);

		Route::post('fileserver-listings', 'Admin\Files\ServerController@listings')->name('fileserver_listings');
		Route::resource('fileserver', 'Admin\Files\ServerController', [
			'names' => [
				'index' => 'admin.fileserver.index',
				'create' => 'admin.fileserver.create',
				'store' => 'admin.fileserver.store',
				'edit' => 'admin.fileserver.edit',
				'update' => 'admin.fileserver.update',
				'destroy' => 'admin.fileserver.destroy'
			]
		]);

		Route::post('filenas-listings', 'Admin\Files\NASController@listings')->name('filenas_listings');
		Route::resource('filenas', 'Admin\Files\NASController', [
			'names' => [
				'index' => 'admin.filenas.index',
				'create' => 'admin.filenas.create',
				'store' => 'admin.filenas.store',
				'edit' => 'admin.filenas.edit',
				'update' => 'admin.filenas.update',
				'destroy' => 'admin.filenas.destroy'
			]
		]);

		Route::get('file/{id}', 'Admin\Files\UploadsController@listings')->name('admin_file_download');
		Route::post('fileuploads-listings', 'Admin\Files\UploadsController@listings')->name('fileuploads_listings');
		Route::resource('fileuploads', 'Admin\Files\UploadsController', [
			'names' => [
				'index' => 'admin.fileuploads.index',
			]
		]);

		Route::post('downloadlogs-listings', 'Admin\Files\DownloadLogsController@listings')->name('downloadlogs_listings');
		Route::resource('downloadlogs', 'Admin\Files\DownloadLogsController', [
			'names' => [
				'index' => 'admin.downloadlogs.index',
			]
		]);

		Route::post('abuses-listings', 'Admin\AbusesController@listings')->name('abuses_listings');
		Route::resource('abuses', 'Admin\AbusesController', [
			'names' => [
				'index' => 'admin.abuses.index',
			]
		]);

		Route::resource('notes', 'Admin\Users\NotesController', [
			'names' => [
				'store' => 'admin.notes.store',
				'update' => 'admin.notes.update',
				'destroy' => 'admin.notes.destroy'
			]
		]);

		Route::get('settings', 'Admin\SettingsController@index')->name('admin_settings');
		Route::any('settings-edit', 'Admin\SettingsController@edit')->name('admin_settings_edit');
	});
});

Route::get('session', function() {
	$url =  'https://jsonplaceholder.typicode.com';

    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', $url .  '/posts/1', [
        'auth' => ['user', 'pass']
    ]);
    echo $res->getStatusCode();
    echo $res->getBody();

});
