<?php

namespace App\Traits;

use App\IotCredential;
use App\IotToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait IotAuth {

    public function authenticate($userId = null)
    {
        $tokens = IotCredential::getTokens($userId);

//        Log::debug($tokens['access_token']);

        $iotLogin = IotCredential::getXtoken($tokens['access_token']);
//        Log::debug($iotLogin['user_id']);
        $expiresAt = Carbon::now()->addSeconds($tokens['expires_in']);

//        dd($tokens);
        $user = $userId ?? Auth::id();
        $iotToken = IotToken::firstOrCreate(
            ['user_id' => $user],
            [
                'access_token' => $tokens['access_token'],
                'jwt_token' => $iotLogin['X-IoT-JWT'],
                'iot_user_id' => $iotLogin['data']['userId'],
                'expires_at' => $expiresAt
            ]);

//        dd($iotToken);

        if ($this->tokensAreValid($iotToken)) {
            return $iotToken;
        }

        $iotToken->access_token = $tokens['access_token'];
        $iotToken->jwt_token = $iotLogin['X-IoT-JWT'];
        $iotToken->iot_user_id = $iotLogin['data']['userId'];
        $iotToken->expires_at = $expiresAt;

        $iotToken->save();

        return $iotToken;

    }

    public function tokensAreValid($iotToken)
    {

//        $iotToken = IotToken::where('user_id', Auth::id());
//        $expiresAt = $iotToken->expires_at;
//        $expiresAt = session()->get('expires_at');
        $now = Carbon::now();

        return $now <= $iotToken->expires_at;

    }
}
