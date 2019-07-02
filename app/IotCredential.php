<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class IotCredential extends Model
{


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getTokens($userId = null)
    {

        $userId = $userId ?? Auth::id();
        $user = IotCredential::where('user_id', $userId)->first();

        $client = new Client();
        $res = $client->request('GET', 'https://iot.dialog.lk/developer/api/applicationmgt/authenticate', [
            'headers' => ['X-Secret' => $user->x_secret ]
        ]);
        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody(), true);
        }

        return $res->getStatusCode();
//        echo $res->getHeader('content-type')[0];
    }

    public static function getXtoken($accessToken)
    {
        $user = IotCredential::where('user_id', Auth::id())->first();
//        dd($user->password);
        $client = new Client();
        $res = $client->post('https://iot.dialog.lk/developer/api/usermgt/v1/authenticate', [
            'headers' => [
                'Authorization' => 'Bearer '.$accessToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'body' => json_encode([
                'username' => $user->username, //$user->iotCredential->username,
                'password' => $user->password
            ])
        ]);

        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody(), true);
        }

        return $res->getStatusCode();
    }

    public function readAccessToken()
    {

    }

    public function writeAccessToken()
    {

    }
}
