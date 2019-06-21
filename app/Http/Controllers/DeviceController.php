<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeviceController extends Controller
{
    public function controlGate($command)
    {

        $device = new Device();
        $response = $device->executeAction( 15077, $command);

        Log::debug(collect($response));

        return $response;
    }
}
