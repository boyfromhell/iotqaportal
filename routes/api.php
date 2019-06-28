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

Route::get('roller-gate/{command}', 'DeviceController@controlGate');

Route::any('receive', 'SubscriberController@store');
Route::any('delete', 'SubscriberController@delete');

Route::post('device/fault/sms', 'SmsController@captureMessage');
