<?php

namespace App\Http\Controllers;

use App\Device;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeviceController extends Controller
{

    public function index()
    {
        $device = new Device();
        $devices = $device->getDevices();
        return view('devices.index', compact('devices'));
    }

    public function show($deviceId)
    {
        $deviceObj = new Device();
        $device = $deviceObj->getDevice($deviceId);
        $actions = $deviceObj->getActions($deviceId);
        $events = $deviceObj->getDeviceEvents($deviceId);
        return view('devices.show', compact('device', 'actions', 'events'));
    }

    public function actions($deviceId)
    {
        $device = new Device();
        return $device->getActions($deviceId);
    }

    public function events($deviceId)
    {
        $device = new Device();
        return $device->getDeviceEvents($deviceId);
    }

    public function executeAction($deviceId, $command)
    {

//        var_dump($deviceId, $command);
        $device = new Device();

        try {

            $response = $device->executeAction((integer)$deviceId, $command);
            Log::debug(collect($response));
            return $response;
        } catch (ClientException $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }

    }

    public function controlGate($command)
    {

        $device = new Device();

        try {

            $response = $device->executeAction(15077, $command);
            Log::debug(collect($response));
            return $response;
        } catch (ClientException $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }

    }
}
