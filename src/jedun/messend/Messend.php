<?php 

namespace Jidan\Jedun\Messend;

use Exception;
use Jidan\Jedun\Messend\Email\Email;

class Messend
{
    public function __get($name)
    {
        switch($name)
        {
            case 'email': return new Email();
        }

        throw new Exception("Object $name Not Found");
    }
}