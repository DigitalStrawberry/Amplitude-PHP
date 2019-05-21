Amplitude PHP
=============

This package provides a PHP wrapper for [Amplitue's HTTP SDK](https://developers.amplitude.com/#http-api).

Events
-------------

```php
$event = new \Amplitude\AmplitudeEvent('Completed Tutorial');

// Set the user id (required if no device id is set)
$event->setUserId(123456);

// Set the device id (required if no user id is set)
$event->setDeviceId('1234-1234-1234-1234');

// Set multiple event properties
$event->setEventProperties([
    'final_score' => 1000,
    'mode' => 'Single Player'
]);

// Or set them one at a time
$event->setEventProperty('final_code', 1000);
```

Logging Revenue
-----
You can set an event as a revenue event by calling the `setRevenue` method.

```php
$event->setRevenue('Remove Ads', 100.00);
```

User Properties
------
You can update user properties when sending an event.

```php
// Set multiple user properties
$event->setUserProperties([
    'city_id' => 123,
    'country_id' => 34
]);

// Or set them one at a time
$event->setUserProperty('city_id', 123);
```


Submitting Events to Amplitude
----

```php
$apiKey = 123456;
$client = new \Amplitude\AmplitudeClient($apiKey);

try
{
    $response = $client->track($event);
}
catch(Exception $e)
{

}
```
If you are queuing the events on your server to later submit in batches, you can generate an insert id for the event. This will prevent Amplitude from recording the event multiple times.

```php
$event->generateInsertId();
```