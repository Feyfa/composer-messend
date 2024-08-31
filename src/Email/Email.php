<?php 

namespace Messend\Email;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Rakit\Validation\Validator;

class Email
{
    public function send(array $credentials)
    {
        /* VALIDATOR */
        $validator = new Validator;

        $validation = $validator->make($credentials, [
            'user_secret_key' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required|integer',
            'mail_encryption' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'to' => 'required|email',
            'subject' => 'required',
            'content' => 'required',
        ]);

        $validation->validate();

        if($validation->fails())
            return ['status' => 'error', 'message' => $validation->errors()->firstOfAll()];
        /* VALIDATOR */

        /** SEND EMAIL */
        $client = new Client();
        $domain = 'https://lightgreen-salmon-353263.hostingersite.com';
        
        try
        {
            $response = $client->request('POST', "$domain/api/gmail/send", ['form_params' => $credentials]);
            $response = json_decode($response->getBody()->getContents(), true);
        }
        catch (RequestException $e)
        {
            // Cek apakah ada respons dari server
            if ($e->hasResponse()) 
            {
                $response = json_decode($e->getResponse()->getBody()->getContents(), true);
                return ['status' => $response['status'], 'message' => $response['message']];
            } 
            else 
            // Jika tidak ada respons, kembalikan pesan exception
            {
                return ['status' => 'error', 'message' => $e->getMessage()];
            }
        }
        /** SEND EMAIL */

        return ['status' => $response->status, 'message' => $response->message];
    }
}