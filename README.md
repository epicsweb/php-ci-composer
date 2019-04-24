# PHP - Message

This library prepares the data and send it to an API for sending emails, sms and other for Code Igniter and Laravel

## Installation

Use the composer to install this library

```bash
composer require epicsweb/php-ci-messages
```

## Configuration

#### CodeIgniter

Create a new file in your code igniter application folder: **/application/config/phpmessages.php**

```php
<?php if( !defined('BASEPATH')) exit('No direct script access allowed');

$config['pm_url']	= 'YOUR_BASE_URL_API';

$config['pm_user']	= 'YOUR_PWD_USERS';

$config['pm_pass']	= 'YOUR_PWD_PASSWORD';
```

#### Laravel

Set in your **.env*** file

```
PM_URL='YOUR_BASE_URL_API';
PM_USER='YOUR_PWD_USERS';
PM_PASS='YOUR_PWD_PASSWORD';
```

## Usage

#### CodeIgniter

Change file **/application/config/config.php**:

```php
$config['composer_autoload'] = FALSE;
↓
$config['composer_autoload'] = realpath(APPPATH . '../vendor/autoload.php');
```

#### CodeIgniter & Laravel

Call the "send_mail" function of this library with an array like unique param

```php
$data = [
    'app'       => [
        'enviado_por'   => (string) 'aplicativo',
        'app_id'        => (int) 1,
        'envio_id'      => (int) 0,
        'para_id'       => (int) '000' //CLIENT_ID
    ],
    'header'    => [
        'para'          => (string) 'for@email.com',
        'de_nome'       => (string) 'YOUR NAME',
        'de'            => (string) 'from@yourname.com',
        'reply_to'      => (string) 'no-reply@yourname.com',
        'copia'         => (boolean) 0 //0 OR 1
    ],
    'corpo'     => [
        'assunto'       => (string) 'Email Subject',
        'html'          => (string) 'Email <br/> Content',
        'texto'         => (string) 'Email Content'
    ],
    'tipo'      => [
        'email'
    ]
];

$message = new PhpMessage( 'ci' ); // 'ci' or 'laravel' framework params (default = ci)
$message = $message->send_email( $data )
 ```

### License
This project is licensed under the MIT License - see the [LICENSE.md](https://github.com/epicsweb/mensagens-php/blob/master/LICENSE) file for details