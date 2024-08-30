<?php 

namespace Jidan\Jedun\Messend\TwoFactoryAuth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Rakit\Validation\Validator;

require_once __DIR__ . "../../../../../vendor/autoload.php";

class TwoFactoryAuth
{
    public function generateOtp(array $credentials)
    {
        /* VALIDATOR */
        $validator = new Validator;

        $validation = $validator->make($credentials, [
            'user_secret_key' => 'required',
            'contact' => 'required',
            'expired' => 'required'
        ]);

        $validation->validate();

        if($validation->fails())
            return ['status' => 'error', 'message' => $validation->errors()->firstOfAll()];
        /* VALIDATOR */

        /* GENERATE OTP */
        $client = new Client();
        $domain = 'https://lightgreen-salmon-353263.hostingersite.com';

        try
        {
            $response = $client->request('POST', "$domain/api/generate/otp", ['form_params' => $credentials]);
            $response = json_decode($response->getBody()->getContents());
        }
        catch (RequestException $e)
        {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
        /* GENERATE OTP */

        return ['status' => $response->status, 'otp_secret_key' => $response->otp_secret_key, 'otp_code' => $response->otp_code, 'contact' => $response->contact];
    }

    public function matchOtp(array $credentials)
    {
        /* VALIDATOR */
        $validator = new Validator;

        $validation = $validator->make($credentials, [
            'user_secret_key' => 'required',
            'otp_secret_key' => 'required',
            'contact' => 'required',
            'otp_code' => 'required',
            'now' => 'required'
        ]);

        $validation->validate();

        if($validation->fails())
            return ['status' => 'error', 'message' => $validation->errors()->firstOfAll()];
        /* VALIDATOR */

        /* MATCH OTP */
        $client = new Client();
        $domain = 'https://lightgreen-salmon-353263.hostingersite.com';

        try
        {
            $response = $client->request('POST', "$domain/api/match/otp", ['form_params' => $credentials]);
            $response = json_decode($response->getBody()->getContents());
        }
        catch (RequestException $e)
        {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
        /* MATCH OTP */

        return ['status' => $response->status, 'message' => $response->message];
    }
}

