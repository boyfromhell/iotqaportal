<?php

namespace App\Listeners;

use App\Device;
use App\Http\Middleware\IoTAPIAuth;
use App\IotCredential;
use App\TestCase;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class RunTestCaseListener implements ShouldQueue
{

    public function handle($event)
    {

        $tokens = IotCredential::getTokens();

        Log::debug((string)$tokens);
//        Log::debug($tokens['access_token']);

//        $iotLogin = IotCredential::getXtoken($tokens['access_token']);
//
//        session()->put('access_token', $tokens['access_token']);
//        session()->put('jwt', $iotLogin['X-IoT-JWT']);
//        session()->put('user_id', $iotLogin['data']['userId']);
//
//        $expiresAt = Carbon::now()->addSeconds($tokens['expires_in']);
//
//        session()->put('expires_at', $expiresAt);
//
//
//
//        $testCase = $event->testCase;
//        $actionSeries = $testCase->sequences;

//        Log::debug('Access Token: ' . session()->get('access_token'));

//        for ($x = 0; $x < $testCase->loops; $x++) {
//            Log::debug('Loop: ' . $x);
//            foreach ($actionSeries as $action) {
//                try {
//
//                    $device = new Device();
//
//                    $response = $device->executeAction((integer)$testCase->device_id, $action->action, json_decode($action->action_params));
//                    Log::debug(collect($response));
//
//                } catch (ClientException $e) {
//                    Log::error($e->getCode() . ': ' . $e->getMessage());
//                }
//
//                Log::debug('waiting for ' . $action->duration . ' s');
//                sleep($action->duration);
//            }
//        }
    }


}
