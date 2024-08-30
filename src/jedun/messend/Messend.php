<?php 

namespace Jidan\Jedun\Messend;

use Exception;
use Jidan\Jedun\Messend\Email\Email;
use Jidan\Jedun\Messend\TwoFactoryAuth\TwoFactoryAuth;

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