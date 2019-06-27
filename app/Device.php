<?php

namespace App;

use App\Http\Middleware\IoTAPIAuth;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Device extends Model
{

    public $accessToken;
    public $jwt;
    public $user_id;

    public function __construct($userId = null)
    {
        $userId = $userId == null ? Auth::id() : $userId;
        $iotToken = IotToken::where('user_id', $userId)->first();
        Log::debug((string)$iotToken);
        $this->accessToken = $iotToken->access_token;
        $this->jwt = $iotToken->jwt_token;
        $this->user_id = $iotToken->iot_user_id;
    }

    public function deviceCategories()
    {
        return $this->belongsToMany(DeviceCategory::class);
    }

    public function iotCredentials()
    {
        return $this->belongsTo(IotCredential::class);
    }


    public function getDevices()
    {

        $client = new Client();
        $res = $client->request('GET', 'https://iot.dialog.lk/developer/api/userdevicemgt/v1/devices', [
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

    public function getActions($deviceId)
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

    public function getEvents($deviceId)
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

    public function executeAction($deviceId, $action, $actionParams = array())
    {

        Log::debug("access_token {$this->accessToken}");
        $client = new Client();

        $body = [
            "operation" => "deviceControl",
            "deviceId" => $deviceId,
            "actionName" => $action,
            "userId" => $this->user_id,
//                "actionParameters" => []
        ];

        if (!empty($actionParams)) {
            $body['actionParameters'] = json_decode($actionParams);
        }
//        dd($body);
//        Log::debug((string)$body);

        $res = $client->post('https://iot.dialog.lk/developer/api/userdevicecontrol/v1/devices/executeaction', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'X-IoT-JWT' => $this->jwt,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'body' => json_encode($body)
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
