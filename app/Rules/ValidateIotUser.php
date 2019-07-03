<?php

namespace App\Rules;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Validation\Rule;

class ValidateIotUser implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $xToken;
    private $username;
    private $password;

    public function __construct($xToken, $username, $password)
    {
        $this->xToken = $xToken;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $client = new Client();

        $res = $client->request('GET', 'https://iot.dialog.lk/developer/api/applicationmgt/authenticate', [
            'headers' => ['X-Secret' => $this->xToken]
        ]);

        $tokens = json_decode($res->getBody(), true);
        try {
            $res = $client->post('https://iot.dialog.lk/developer/api/usermgt/v1/authenticate', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $tokens['access_token'],
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
                'body' => json_encode([
                    'username' => $this->username,
                    'password' => $this->password
                ])
            ]);

            if ($res->getStatusCode() == 200) {
                return true;
            }
        } catch (ClientException $e) {
            return false;

        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please check your Ideamart IoT Username and Password';
    }
}
