<?php

namespace App\Http\Middleware;

use Closure;

class IoTAPIAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();



        session()->put('accessToken');
        return $next($request);
    }
}
