<?php

namespace App\Http\Middleware;

use App\IotCredential;
use App\IotToken;
use App\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IoTAPIAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {

        $tokens = IotCredential::getTokens();
//        Log::debug($tokens['access_token']);
        $iotLogin = IotCredential::getXtoken($tokens['access_token']);
//        Log::debug($iotLogin['user_id']);
        $expiresAt = Carbon::now()->addSeconds($tokens['expires_in']);

//        $user = User::find(Auth::id());
        $iotToken = IotToken::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'access_token' => $tokens['access_token'],
                'jwt_token' => $iotLogin['X-IoT-JWT'],
                'iot_user_id' => $iotLogin['data']['userId'],
                'expires_at' => $expiresAt
            ]);

        if ($this->tokensAreValid($iotToken)) {
            return $next($request);
        }

        $iotToken->access_token = $tokens['access_token'];
        $iotToken->jwt_token = $iotLogin['X-IoT-JWT'];
        $iotToken->iot_user_id = $iotLogin['data']['userId'];
        $iotToken->expires_at = $expiresAt;

        $iotToken->save();
        return $next($request);

//        session()->put('access_token', $tokens['access_token']);
//        session()->put('jwt', $iotLogin['X-IoT-JWT']);
//        session()->put('user_id', $iotLogin['data']['userId']);

//        session()->put('expires_at', $expiresAt);


//        session()->put('exp_time', $tokens['expiry_time']);


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
