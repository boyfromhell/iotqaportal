<?php

namespace App\Http\Controllers;

use App\Device;
use App\IotCredential;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IotCredentialController extends Controller
{

    public function authenticate()
    {
//        $iotLogin = new IotCredential();
//        $tokens = $iotLogin->getTokens();
//        $accessToken = $stream->();
//        return $iotLogin->getXtoken($tokens['access_token']);

        $tokens = IotCredential::getTokens();
        $iotLogin = IotCredential::getXtoken($tokens['access_token']);

//        return $iotLogin['X-IoT-JWT'];

//        return $devices = Device::getDevices($tokens['access_token'], $iotLogin['X-IoT-JWT']);
//        return $devices = Device::getDevice($tokens['access_token'], $iotLogin['X-IoT-JWT'], 16572);
//        return $devices = Device::getDeviceActions($tokens['access_token'], $iotLogin['X-IoT-JWT'], 16572);
//        return $iotLogin['data']['userId'];

        $actions = ["u", "d", "p"];



        for ($i = 0; $i < 20; $i++) {
            $x = rand(0, 2);

//            Log::debug($actions[$x]);
            $devices = Device::executeAction($tokens['access_token'], $iotLogin['X-IoT-JWT'], 15077, $iotLogin['data']['userId'], $actions[$x]);


            Log::debug(($i+1).": {$actions[$x]}".collect($devices));
            sleep('3');
        }

        return 'Done';


//        $iotLogin = IotCredential::getXtoken($tokens['access_token']);


    }

}
