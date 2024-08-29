<?php 

namespace Jidan\Jedun\Messend\Email;

use Rakit\Validation\Validator;

require_once __DIR__ . "../../../../../vendor/autoload.php";

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
            return ['result' => 'error', 'message' => $validation->errors()];
        /* VALIDATOR */

        return ['result' => 'success'];
    }
}