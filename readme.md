# Messend - Sending Messages with PHP

Messend is a bridge to send messages to Gmail, Twilio Whatsapp, Twilio Sms platforms. Messend can also be used for the Two Factory Auth feature.

## Installation

Install the latest version with

```bash
composer require jedun/messend
```

## Send Email

```php
<?php

use Messend\Messend;

// no need use try catch, because is already handle on library
$result = $messend->email->send([
    'user_secret_key' => 'user_secret_key',
    'mail_host' => 'mail_host',
    'mail_port' => 'mail_port',
    'mail_encryption' => 'mail_encryption',
    'mail_username' => 'mail_username@example.com',
    'mail_password' => 'mail_password',
    'to' => 'to@example.com',
    'subject' => 'Subject',
    'content' => '<strong>Content</strong>',
]);
var_dump($result);
```

## Generate Otp

```php
<?php

use Messend\Messend;

// no need use try catch, because is already handle on library
$result = $messend->tfa->generateOtp([
    'user_secret_key' => 'user_secret_key',
    'contact' => 'contact@example.com',
    'expired' => EPOCH_TIME_EXPIRED
]);
var_dump($result);
```

## Match Otp

```php
<?php

use Messend\Messend;

// no need use try catch, because is already handle on library
$result = $messend->tfa->matchOtp([
    'user_secret_key' => 'user_secret_key',
    'otp_secret_key' => 'otp_secret_key',
    'contact' => 'contact@example.com',
    'otp_code' => '123456',
    'now' => EPOCH_TIME_NOW
]);
var_dump($result);
```

## Send Whatsapp

```php
<?php

use Messend\Messend;

// no need use try catch, because is already handle on library
$messend = new Messend();
$result = $messend->twilio->send([
    'user_secret_key' => 'user_secret_key',
    'twilio_type' => 'whatsapp',
    'twilio_sid' => 'twilio_sid',
    'twilio_auth_token' => 'twilio_auth_token',
    'twilio_number_from' => '+1234xxxxx',
    'twilio_number_to' => '+62812xxxxx',
    'twilio_body' => 'message',
]);

var_dump($result);
```

## Send Sms

```php
<?php

use Messend\Messend;

// no need use try catch, because is already handle on library
$messend = new Messend();
$result = $messend->twilio->send([
    'user_secret_key' => 'user_secret_key',
    'twilio_type' => 'sms',
    'twilio_sid' => 'twilio_sid',
    'twilio_auth_token' => 'twilio_auth_token',
    'twilio_number_from' => '+1234xxxxx',
    'twilio_number_to' => '+62812xxxxx',
    'twilio_body' => 'message',
]);

var_dump($result);
```

### Requirements

- Messend `^1.0` works with PHP 7.4 or above.