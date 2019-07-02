<?php

namespace App;

use App\Http\Middleware\IoTAPIAuth;
use App\Traits\IotAuth;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Device extends Model
{
    use IotAuth;

    public $accessToken;
    public $jwt;
    public $user_id;

    public function __construct($user = null)
    {
        $x = $this->authenticate($user);
        $this->accessToken = $x->access_token;
        $this->jwt = $x->jwt_token;
        $this->user_id = $x->iot_user_id;
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


//        dd($this->accessToken, $this->jwt);
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

    public function executeTestAction($deviceId, $action, $actionParams = array())
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

        return $res;
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

    public function getDeviceSelect()
    {
        $devices = collect($this->getDevices());
        return $devices->mapWithKeys(function ($value) {
            return [$value['id'] => $value['name']];
        });

    }

}
