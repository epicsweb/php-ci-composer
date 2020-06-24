
# PHP - Message

This library prepares the data and send it to an API for sending emails, sms and other for Code Igniter and Laravel

## Installation

Use the composer to install this library

```bash
composer require epicsweb/php-ci-messages
```

## Configuration

#### CodeIgniter

Create or edit a file in your code igniter application folder and set this vars: **/application/config/epicsweb.php**

```php
<?php if( !defined('BASEPATH')) exit('No direct script access allowed');

$config['pm_url']   = 'YOUR_BASE_URL_API';
$config['pm_user']  = 'YOUR_PWD_USERS';
$config['pm_pass']  = 'YOUR_PWD_PASSWORD';
```

#### Laravel

Set in your **.env** file

```
PM_URL=YOUR_BASE_URL_API;
PM_USER=YOUR_PWD_USERS;
PM_PASS=YOUR_PWD_PASSWORD;
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
        'envio_id'      => (int) 1,
        'para_id'       => (int) 1 //CLIENT_ID
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
$message = $message->send_mail( $data )
 ```
------------

##### New SMS

Call the "send_sms" function of this library with an array like unique param to send a new sms

```php
$sms = [
    'app'       => [
        'enviado_por'   => (string) 'aplicativo',
        'app_id'        => (int) 1,
        'envio_id'      => (int) 1,
        'para_id'       => (int) 1 //CLIENT_ID
    ],
    'header'    => [
        'para'          => '5517911112222'
        'de_nome'       => 'EPICS',
        'de'            => 'epics@epics.com.br',
    ],
    'corpo'     => [
        'assunto'       => (string) 'Message Here',
        'html'          => (string) 'Message Here',
        'texto'         => (string) 'Message Here',
    ],
    'tipo'      => [
        'sms'
    ]
];
$message = new PhpMessage( 'ci' ); // 'ci' or 'laravel' framework params (default = ci)
$message = $message->send_sms( $sms );
```
------------

##### Push

###### Create Push
```php
$data = [
    'user_id'         => 1,
    'title'              => 'New push notification',
    'body'            => 'Description of your push notification', 
    'customData'  => []
];
$this->message->push_create($data);```

###### Tokens - Get All
```php
$data = [
    'user_id'    => 1
];
$this->message->push_tokens($data);```

###### Tokens - Create One
```php
$data = [
    'user_id'    => 1,
    'token'      => 'a1b2c3d4f5',
    'device'     => 'IOS|ANDROID|WEB'
];
$this->message->push_token_create($data);```

###### Tokens - Remove One
```php
$data = [
    'token'    =>  'a1b2c3d4f5'
];
$this->message->push_remove($data);```

------------

##### Mailchimp Manage

###### Edit

Call the "mailchimp_edit" function of this library with an array like unique param to edit a member in Mailchimp list. Obs: if the member doesn't exist, the function will call mailchimp_create automatically.

```php
$data = [
    'id'                = (string) 'abc123', // id da lista
    'email_address'     = 'user email',
    'email_type'        = 'email type',
    'status'            = 'member status',
    'merge_fields' => [
        'name'          => (string) 'User name',
        'country'       => (string) 'User country',
        'state'         => (string) 'User state',
        'city'          => (string) 'User city',
        'phone'         => (string) 'User phone',
    ]
];
$message = new PhpMessage( 'ci' ); // 'ci' or 'laravel' framework params (default = ci)
$message = $message->mailchimp_edit( $data );
```

###### Edit Tags

Call the "mailchimp_tag" function of this library with an array like unique param to edit tags from member in Mailchimp list.

```php
$data = [
    'id'                = 'list id',
    'email_address'     = 'user email',
    'tags' => [
        'name'          => (string) 'Tag Name',
        'status'        => (string) 'Tag Status' //active/inactive
    ]
];
$message = new PhpMessage( 'ci' ); // 'ci' or 'laravel' framework params (default = ci)
$message = $message->mailchimp_edit( $data );
```

------------

### License
This project is licensed under the MIT License - see the [LICENSE.md](https://github.com/epicsweb/mensagens-php/blob/master/LICENSE) file for details