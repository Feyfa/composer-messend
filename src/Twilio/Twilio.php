<?php 

namespace Messend\Twilio;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Rakit\Validation\Validator;

class Twilio
{
    public function sendWhatsapp(array $credentials)
    {
        /* VALIDATOR */
        $validator = new Validator;

        $validation = $validator->make($credentials, [
            'user_secret_key' => 'required',
            'twilio_sid' => 'required',
            'twilio_auth_token' => 'required',
            'twilio_number_from' => 'required',
            'twilio_number_to' => 'required',
            'twilio_body' => 'required',
        ]);

        $validation->validate();

        if($validation->fails())
            return (object) ['status' => 'error', 'message' => $validation->errors()->firstOfAll()];
        /* VALIDATOR */

        /** SEND TWILIO WHATSAPP */
        $client = new Client();
        $domain = 'https://lightgreen-salmon-353263.hostingersite.com';
        
        try
        {
            $response = $client->request('POST', "$domain/api/twilio/whatsapp/send", ['form_params' => $credentials]);
            $response = json_decode($response->getBody()->getContents());
        }
        catch (RequestException $e)
        {
            // Cek apakah ada respons dari server
            if ($e->hasResponse()) 
            {
                $response = json_decode($e->getResponse()->getBody()->getContents());
                return (object) ['status' => $response->status, 'message' => $response->message];
            } 
            else 
            // Jika tidak ada respons, kembalikan pesan exception
            {
                return (object) ['status' => 'error', 'message' => $e->getMessage()];
            }
        }
        /** SEND TWILIO WHATSAPP */

        return (object) ['status' => $response->status, 'message' => $response->message];
    }

    public function sendSms(array $credentials)
    {
        /* VALIDATOR */
        $validator = new Validator;

        $validation = $validator->make($credentials, [
            'user_secret_key' => 'required',
            'twilio_sid' => 'required',
            'twilio_auth_token' => 'required',
            'twilio_number_from' => 'required',
            'twilio_number_to' => 'required',
            'twilio_body' => 'required',
        ]);

        $validation->validate();

        if($validation->fails())
            return (object) ['status' => 'error', 'message' => $validation->errors()->firstOfAll()];
        /* VALIDATOR */

        /** SEND TWILIO SMS */
        $client = new Client();
        $domain = 'https://lightgreen-salmon-353263.hostingersite.com';
        
        try
        {
            $response = $client->request('POST', "$domain/api/twilio/sms/send", ['form_params' => $credentials]);
            $response = json_decode($response->getBody()->getContents());
        }
        catch (RequestException $e)
        {
            // Cek apakah ada respons dari server
            if ($e->hasResponse()) 
            {
                $response = json_decode($e->getResponse()->getBody()->getContents());
                return (object) ['status' => $response->status, 'message' => $response->message];
            } 
            else 
            // Jika tidak ada respons, kembalikan pesan exception
            {
                return (object) ['status' => 'error', 'message' => $e->getMessage()];
            }
        }
        /** SEND TWILIO SMS */

        return (object) ['status' => $response->status, 'message' => $response->message];
    }
}