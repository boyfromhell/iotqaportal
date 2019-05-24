<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Device extends Model
{
    public function deviceCategories()
    {
        return $this->belongsToMany(DeviceCategory::class);
    }

    public function iotDeviceCredentials()
    {
        return $this->belongsTo(IotCredential::class);
    }


    public static function getDevices($accessToken, $jwtToken)
    {
//        $user = IotCredential::where('user_id', Auth::id())->first();

//        dd($jwtToken);

        $client = new Client();
        $res = $client->request('GET', 'https://iot.dialog.lk/developer/api/userdevicemgt/v1/devices', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'X-IoT-JWT' => $jwtToken
            ]
        ]);
        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody(), true);
        }

        return $res->getStatusCode();
    }

    public static function getDevice($accessToken, $jwtToken, $deviceId)
    {

        $client = new Client();
        $res = $client->request('GET', "https://iot.dialog.lk/developer/api/userdevicemgt/v1/devices/{$deviceId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'X-IoT-JWT' => $jwtToken
            ]
        ]);
        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody(), true);
        }

        return $res->getStatusCode();
    }

    public static function getDeviceActions($accessToken, $jwtToken, $deviceId)
    {

        $client = new Client();
        $res = $client->request('GET', "https://iot.dialog.lk/developer/api/userdevicemgt/v1/devices/{$deviceId}/actions", [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'X-IoT-JWT' => $jwtToken
            ]
        ]);
        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody(), true);
        }

        return $res->getStatusCode();
    }

    public static function getDeviceEvents($accessToken, $jwtToken, $deviceId)
    {

        $client = new Client();
        $res = $client->request('GET', "https://iot.dialog.lk/developer/api/userdevicemgt/v1/devices/{$deviceId}/events", [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'X-IoT-JWT' => $jwtToken
            ]
        ]);
        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody(), true);
        }

        return $res->getStatusCode();
    }

    public static function executeAction($accessToken, $jwtToken, $deviceId, $userId )
    {

        $client = new Client();
        $res = $client->post('https://iot.dialog.lk/developer/api/userdevicecontrol/v1/devices/executeaction', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'X-IoT-JWT' => $jwtToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'body' => json_encode([
                "operation" => "deviceControl",
                "deviceId" => $deviceId,
                "actionName" => "RGB",
                "userId" => $userId,
                "actionParameters" => [
                    "red" => 10,
                    "green" => 20,
                    "blue" => 30,
                ]
            ])
        ]);

        if ($res->getStatusCode() === 200) {
            return json_decode($res->getBody(), true);
        }

        return $res->getStatusCode();
    }

}
