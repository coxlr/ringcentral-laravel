
## RingCentral Package for Laravel

## Introduction

This is a simple Laravel Service Provider providing access to the [RingCentral SDK for PHP][client-library].

Installation
------------

To install the PHP client library using Composer:

```bash
composer require coxy121/ringcentral-laravel
```

Alternatively, add these two lines to your composer require section:

```json
{
    "require": {
        "coxy121/ringcentral-laravel": "^1.0"
    }
}
```

### Laravel 5.5+

If you're using Laravel 5.5 or above, the package will automatically register the `RingCentral` provider and facade.

### Laravel 5.4 and below

Add `RingCentral\Laravel\RingCentralServiceProvider` to the `providers` array in your `config/app.php`:

```php
'providers' => [
    // Other service providers...

    RingCentral\Laravel\RingCentralServiceProvider::class,
],
```

If you want to use the facade interface, you can `use` the facade class when needed:

```php
use RingCentral\Laravel\Facade\RingCentral;
```

Or add an alias in your `config/app.php`:

```php
'aliases' => [
    ...
    'RingCentral' => RingCentral\Laravel\Facade\RingCentral::class,
],
```

Configuration
-------------

You can use `artisan vendor:publish` to copy the distribution configuration file to your app's config directory:

```bash
php artisan vendor:publish
```

Then update `config/ringcentral.php` with your credentials. Alternatively, you can update your `.env` file with the following:

```dotenv
RINGCENTRAL_CLIENT_ID=my_client_id
RINGCENTRAL_CLIENT_SECRET=my_client_secret
RINGCENTRAL_SERVER_URL=my_server_url
RINGCENTRAL_USERNAME=my_username
RINGCENTRAL_OPERATOR_EXTENSION=my_operator_extension
RINGCENTRAL_OPERATOR_PASSWORD=my_operator_password

#If admin details are a different extension to the operator
RINGCENTRAL_ADMIN_EXTENSION=my_admin_extension
RINGCENTRAL_ADMIN_PASSWORD=my_admin_password


```

Usage
-----
   
To use the RingCentral Client Library you can use the facade, or request the instance from the service container.

### Sending an SMS message (requires login in extension to be comany operator)

```php
RingCentral::sendMessage([
    'to'   => '13107960080',
    'text' => 'Using the facade to send a message.'
]);
```

Or

```php
$ringcentral = app('ringcentral');

$ringcentral->sendMessage([
    'to'   => '13107960080',
    'text' => 'Using the instance to send a message.'
]);
```


#### Properties

| Name      | Required | Type          | Default     | Description |
| ---       | ---      | ---           | ---         | ---         |
| to        | true      | String     |             | The number to send the message to, must include country code |
| text        | true      | String   |             | The text of the message to send |

### Retreiving Extensions (requires admin access)

```php
RingCentral::getExtensions();
```

Or

```php
$ringcentral = app('ringcentral');

$ringcentral->getExtensions();
```

### Get messages sent and received for the operator

```php
RingCentral::getOperatorMessages();
```

Or

```php
$ringcentral = app('ringcentral');

$ringcentral->getOperatorMessages();
```

The default from date is the previous 24 hours, to specficy the date to search from pass the require date as a parameter.

```php
RingCentral::getOperatorMessages((new \DateTime())->modify('-1 hours'));
```

#### Properties

| Name      | Required | Type          | Default     | Description |
| ---       | ---      | ---           | ---         | ---         |
| fromDate  | false    | DateTime      |             | The date and time to start the search from must be in the format Y-m-d\TH:i:s.z\Z |


### Get messages sent and received for a given extension (Needs admin access)

```php
RingCentral::getMessagesForExtensionId(12345678);
```

Or

```php
$ringcentral = app('ringcentral');

$ringcentral->getMessagesForExtensionId(12345678);
```

The default from date is the previous 24 hours, to specficy the date to search from pass the require date as a parameter.

```php
RingCentral::getMessagesForExtensionId(12345678, (new \DateTime())->modify('-1 hours'));
```

#### Properties

| Name      | Required | Type          | Default     | Description |
| ---       | ---      | ---           | ---         | ---         |
| extensionId  | true    | String      |             | The ringcentral extension Id of the extension to retreive the messages for |
| fromDate  | false    | DateTime      |             | The date and time to start the search from must be in the format Y-m-d\TH:i:s.z\Z |



### Get a messages attachment (requires admin access)

```php
RingCentral::getMessageAttachmentById(12345678, 910111213, 45678910);
```

Or

```php
$ringcentral = app('ringcentral');

$ringcentral->getMessageAttachmentById(12345678, 910111213, 45678910);
```


#### Parameters

| Name      | Required | Type          | Default     | Description |
| ---       | ---      | ---           | ---         | ---         |
| extensionId  | true    | String      |             | The ringcentral extension Id of the extension the messages belongs to |
| messageId  | true    | String      |             | The id of the message of the the attachment belongs to |
| attachmentId  | true    | String      |             | The id of the attachment |



For more information on using the RingCentral client library, see the [official client library repository][client-library].

[client-library]: https://github.com/ringcentral/ringcentral-php
