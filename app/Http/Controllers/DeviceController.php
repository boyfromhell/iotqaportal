<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function controlGate($command)
    {

        $device = new Device();
        return $response = $device->executeAction( 15077, $command);
    }
}
