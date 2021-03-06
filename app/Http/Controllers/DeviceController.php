<?php

namespace App\Http\Controllers;

use App\Device;
use App\TestCase;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeviceController extends Controller
{

    public function index()
    {
        $device = new Device();
        $devices = $device->getDevices();
//        dd($devices);
        return view('devices.index', compact('devices'));
    }

    public function show($deviceId)
    {
        $deviceObj = new Device();
        $device = $deviceObj->getDevice($deviceId);
        $actions = $deviceObj->getActions($deviceId);
        $events = $deviceObj->getEvents($deviceId);
        $tests = TestCase::where('device_id',$deviceId)->get();
        return view('devices.show', compact('device', 'actions', 'events', 'tests'));
    }

    public function actions($deviceId)
    {
        $device = new Device();
        return $device->getActions($deviceId);
    }

    public function events($deviceId)
    {
        $device = new Device();
        return $device->getEvents($deviceId);
    }

    public function executeAction($deviceId, $command)
    {

//        var_dump($deviceId, $command);
        $device = new Device();

        try {

            $response = $device->executeAction((integer)$deviceId, $command);
            Log::debug(collect($response));
            session()->flash('success', 'Successfully Executed');
            return redirect()->back();
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
