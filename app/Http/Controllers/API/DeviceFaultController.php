<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class DeviceFaultController extends Controller
{

    /**
     * @param Request $request
     */
    public function captureMessage(Request $request)
    {
        Log::debug("Incoming SMS: ".(string)$request->all());



        return 200;
    }
}
