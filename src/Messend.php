<?php 

namespace Messend;

use Exception;
use Messend\Email\Email;
use Messend\Twilio\Twilio;
use Messend\TwoFactoryAuth\TwoFactoryAuth;

/**
 * @property-read Email $email
 * @property-read TwoFactoryAuth $tfa
 * @property-read Twilio $twilio
 */
class Messend
{
    public function __get($name)
    {
        switch($name)
        {
            case 'email': return new Email();
            case 'tfa': return new TwoFactoryAuth();
            case 'twilio': return new Twilio();
        }

        throw new Exception("Object $name Not Found");
    }
}