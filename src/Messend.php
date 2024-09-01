<?php 

namespace Messend;

use Exception;
use Messend\Email\Email;
use Messend\TwoFactoryAuth\TwoFactoryAuth;

/**
 * @property-read Email $email
 * @property-read TwoFactoryAuth $tfa
 */
class Messend
{
    public function __get($name)
    {
        switch($name)
        {
            case 'email': return new Email();
            case 'tfa': return new TwoFactoryAuth();
        }

        throw new Exception("Object $name Not Found");
    }
}