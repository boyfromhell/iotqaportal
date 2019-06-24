<?php

namespace App\Http\Controllers;

use App\Device;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeviceController extends Controller
{

    public $device;

    public function __construct()
    {
//        $this->device =
    }

    public function index()
    {

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
