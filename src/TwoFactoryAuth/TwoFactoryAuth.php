<?php 

namespace Messend\TwoFactoryAuth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Rakit\Validation\Validator;

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
            // Cek apakah ada respons dari server
            if ($e->hasResponse()) 
            {
                $response = json_decode($e->getResponse()->getBody()->getContents());
                return ['status' => $response->status, 'message' => $response->message];
            } 
            else 
            // Jika tidak ada respons, kembalikan pesan exception
            {
                return ['status' => 'error', 'message' => $e->getMessage()];
            }
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

