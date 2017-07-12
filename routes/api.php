<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('ip', 'API\ApiController@getIp');
Route::any('geolocation', 'API\ApiController@getGeolocation');
Route::any('check-file-md5', 'API\ApiController@getCheckFileMd5');
Route::any('folders', 'API\ApiController@getFolders');
Route::any('check-servers', 'API\ApiController@getCheckServers');
Route::any('generate-delete-hash', 'API\ApiController@getGenerateDeleteHash');
Route::any('update/{id}/{data}', 'API\ApiController@getUpdate');
Route::post('insert', 'API\ApiController@getInsert');
Route::any('increment', 'API\ApiController@getIncrement');

Route::any('get-filenas', 'API\ApiController@getFilenas');

Route::any('generate-filename', 'API\ApiController@generateFilename');

Route::any('find-md5/{md5}', 'API\ApiController@getFindMd5');
Route::any('user-logged', 'API\ApiController@getUserLogged');
Route::any('user-details', 'API\ApiController@getUserDetails');
Route::any('settings', 'API\ApiController@getSettings');
Route::any('user-check', 'API\ApiController@getUserCheck');
Route::any('update-user-file-stat/{increment}/{bytes}/{userid}', 'API\ApiController@getUpdateUserFileStat');
Route::any('update-file-server-space/{increment}/{bytes}/{userid}', 'API\ApiController@getUpdateFileServerSpace');
Route::any('global-stats', 'API\ApiController@getIncrementGlobalStats');

Route::any('upload-abuse', 'API\ApiController@getUploadAbuse');
Route::any('generate-code', 'API\ApiController@getGenerateCode');
Route::any('remote-upload', 'API\ApiController@postRemoteUpload');


Route::any('test', 'API\TestController@index');

Route::any('up', 'TestController@test');