<?php

namespace App;

use App\Http\Middleware\IoTAPIAuth;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Device extends IoTAPIAuth
{

    public $accessToken;
    public $jwt;
    public $user_id;

    public function __construct()
    {
        $this->accessToken = session()->get('access_token');
        $this->jwt = session()->get('jwt');
        $this->user_id = session()->get('user_id');
    }

    public function deviceCategories()
    {
        return $this->belongsToMany(DeviceCategory::class);
    }

    public function iotDeviceCredentials()
    {
        return $this->belongsTo(IotCredential::class);
    }


    public function getDevices()
    {
//        $user = IotCredential::where('user_id', Auth::id())->first();

//        dd($jwtToken);

        $client = new Client();
        $res = $client->request('GET', 'https://iot.dialog.lk/developer/api/userdevicemgt/v1/devices', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'X-IoT-JWT' => $this->jwt
            ]
        ]);
        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody(), true);
        } else {
            $tokens = IotCredential::getTokens();
            $iotLogin = IotCredential::getXtoken($tokens['access_token']);

            self::getDevices($this->accessToken, $this->jwt);
        }

        return $res->getStatusCode();
    }

    public function getDevice($deviceId)
    {

        $client = new Client();
        $res = $client->request('GET', "https://iot.dialog.lk/developer/api/userdevicemgt/v1/devices/{$deviceId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'X-IoT-JWT' => $this->jwt
            ]
        ]);
        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody(), true);
        }

        return $res->getStatusCode();
    }

    public function getDeviceActions($accessToken, $jwtToken, $deviceId)
    {

        $client = new Client();
        $res = $client->request('GET', "https://iot.dialog.lk/developer/api/userdevicemgt/v1/devices/{$deviceId}/actions", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'X-IoT-JWT' => $this->jwt
            ]
        ]);
        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody(), true);
        }

        return $res->getStatusCode();
    }

    public  function getDeviceEvents($deviceId)
    {

        $client = new Client();
        $res = $client->request('GET', "https://iot.dialog.lk/developer/api/userdevicemgt/v1/devices/{$deviceId}/events", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'X-IoT-JWT' => $this->jwt
            ]
        ]);
        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody(), true);
        }
        return $res->getStatusCode();
    }

    public function executeAction($deviceId, $action)
    {

//        Log::debug("access_token {$this->accessToken}");
        $client = new Client();
        $res = $client->post('https://iot.dialog.lk/developer/api/userdevicecontrol/v1/devices/executeaction', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'X-IoT-JWT' => $this->jwt,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'body' => json_encode([
                "operation" => "deviceControl",
                "deviceId" => $deviceId,
                "actionName" => $action,
                "userId" => $this->user_id,
//                "actionParameters" => []
            ])
        ]);

        if ($res->getStatusCode() === 200) {
            return json_decode($res->getBody(), true);
        }
        return $res->getStatusCode();
    }

    public function createDevice($body = array())
    {
        $client = new Client();
        $res = $client->post('https://iot.dialog.lk/developer/api/userdevicecontrol/v1/devices', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'X-IoT-JWT' => $this->jwt,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'body' => json_encode([
                "deviceDefinitionId" => $body["deviceDefinitionId"],
                "brand" => $body["brand"],
                "type" => $body["type"],
                "model" => $body["model"],
                "userId" => $body["userId"],
                "deviceParentId" => $body["deviceParentId"],
                "macAddress" => $body["macAddress"],
                "name" => $body["name"],
                "additionalParams" => $body["additionalParams"],
                "featured" => $body["featured"],
                "nonDeletable" => $body["nonDeletable"],
                "pullInterval" => $body["pullInterval"],
                "zoneId" => $body["zoneId"],
            ])
        ]);

        if ($res->getStatusCode() === 200) {
            return json_decode($res->getBody(), true);
        }

        return $res->getStatusCode();
    }

}
