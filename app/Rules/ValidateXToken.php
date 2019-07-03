<?php

namespace App\Rules;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Validation\Rule;

class ValidateXToken implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        try {
            $client = new Client();
            $res = $client->request('GET', 'https://iot.dialog.lk/developer/api/applicationmgt/authenticate', [
                'headers' => ['X-Secret' => $value]
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
        return 'We couldn\'t validate your X-token';
    }
}
