<?php

namespace App\Http\Middleware;

use App\IotCredential;
use Carbon\Carbon;
use Closure;
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
//        return 'Hi';

        if ($this->tokensAreValid()) {
            return $next($request);
        }

        $tokens = IotCredential::getTokens();

//        Log::debug($tokens['access_token']);

        $iotLogin = IotCredential::getXtoken($tokens['access_token']);
//        Log::debug($iotLogin['user_id']);

        session()->put('access_token', $tokens['access_token']);
        session()->put('jwt', $iotLogin['X-IoT-JWT']);
        session()->put('user_id', $iotLogin['data']['userId']);

        $expiresAt = Carbon::now()->addSeconds($tokens['expires_in']);

        session()->put('expires_at', $expiresAt);

        return $next($request);


//        session()->put('exp_time', $tokens['expiry_time']);


    }

    public function tokensAreValid()
    {

        if (!session()->has('expires_at') || !session()->has('access_token') || !session()->has('jwt')) {
            return false;
        }

        $expiresAt = session()->get('expires_at');
        $now = Carbon::now();

        return $now <= $expiresAt;

    }
}
