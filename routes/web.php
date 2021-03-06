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

Route::get('/', function () {
    return view('welcome');
});

Route::get('pw', function(){
   return bcrypt('1234');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/get-access-token', function () {

    $user = \App\User::with('iotCredential')->find(Auth::id());
    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'iot.dialog.lk/developer/api/applicationmgt/authenticate', [
        'headers' => ['X-Secret' => $user->iotCredential->x_secret]
    ]);
    echo $res->getStatusCode();
// "200"
    echo $res->getHeader('content-type')[0];
// 'application/json; charset=utf8'
    echo $res->getBody();
// {"type":"User"...'

// Send an asynchronous request.
//    $request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
//    $promise = $client->sendAsync($request)->then(function ($response) {
//        echo 'I completed! ' . $response->getBody();
//    });
//    $promise->wait();
});

Route::get('authenticate', 'IotCredentialController@authenticate')->middleware('auth', \App\Http\Middleware\IoTAPIAuth::class);

Route::get('roller-gate/{command}', 'DeviceController@controlGate')->middleware('auth', \App\Http\Middleware\IoTAPIAuth::class);


Route::group(['prefix' => 'devices'], function () {
    Route::get('/', 'DeviceController@index')->middleware('auth', \App\Http\Middleware\IoTAPIAuth::class);
    Route::get('/ds', function (){
        $devices = new \App\Device();
        return $devices->getDeviceSelect();
    });
    Route::get('{id}', 'DeviceController@show')->middleware('auth', \App\Http\Middleware\IoTAPIAuth::class);
    Route::get('{id}/actions', 'DeviceController@actions')->middleware('auth', \App\Http\Middleware\IoTAPIAuth::class);
    Route::get('{id}/events', 'DeviceController@actions')->middleware('auth', \App\Http\Middleware\IoTAPIAuth::class);
    Route::get('{id}/action/{action}', 'DeviceController@executeAction')->middleware('auth', \App\Http\Middleware\IoTAPIAuth::class);
//    Route::get('{id}/status', 'DeviceController@actions');


});


Route::get('test/{id}', 'SequenceController@runTest')->middleware('auth', \App\Http\Middleware\IoTAPIAuth::class);



