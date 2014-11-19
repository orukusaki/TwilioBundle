# TwilioBundle
Enables Twilio integration in Symfony2 apps

[![Build Status](https://travis-ci.org/orukusaki/TwilioBundle.svg)](https://travis-ci.org/orukusaki/TwilioBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/orukusaki/TwilioBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/orukusaki/TwilioBundle/?branch=master)

This bundle provides:
* The Twilio client + config to make it available as a service
* A bunch of payloads objects and ParamConverters, for receiving inbound requests
* A controller with actions for all the inbound Twilio request types
* Fluent TwiML response creation

Each part is optional, so for example if you want to implement your own controller, you can still use the other parts of this bundle.

## Twilio Client
To use the Twilio API client, you need to add settings to your config.yml:
```yml
orukusaki_twilio:
    client:
        account_id: <your account id>
        token: <your api token>
```
The service will then be available to inject as ```twilio.client```

## Receiving Twilio Events

For inbound calls, sms messages, statuses etc, there is an inbuilt controller. You can add it to your routing using:
```yml
twilio:
    resource: "@OrukusakiTwilioBundle/Controller/TwilioController.php"
    type:     annotation
    prefix:   twilio
```

Whenever an inbound request is received, an event is fired. Create an event listener to process the event, and create a response to be returned:
```php
<?php
namespace Acme\AppBundle\Listener;

use Orukusaki\TwilioBundle\TwilioEvent;
use Orukusaki\TwiML\Voice\Response;

class CallHandler
{
    public function handleCall(TwilioEvent $event)
    {
        $call = $event->getPayload();

        $response = new Response();
        $response->say('Hi, you are calling from ' . $call->from);

        $event->setResponse($response);
    }
}
```
Adding a response to the event stops propagation. If your event listener doesn't add a response to the event, then other listeners will be called.
To listen to the event, simply add a definition for your service, with the appropriate tag:
```xml
<service id="my.call.listener" class="Acme\AppBundle\Listener\CallHandler">
    <tag name="kernel.event_listener" event="twilio.inbound" method="handleCall" />
</service>
```
The events you can listen to are:
* ```twilio.inbound``` An incoming call is received
* ```twilio.status``` For Status Callbacks
* ```twilio.recording``` For recordings
* ```twilio.sms``` For sms messages

## Creating responses

More examples on https://github.com/orukusaki/TwiML/blob/master/README.md

## Callbacks and Recordings

If you're requesting a recording or a dial with a callback, then you need to remember to set the correct url as the 'action' attribute.  Simplest way is to inject the router to your listener, then use it to generate the correct url, like:
```php
$response->dial('+441142000000')
         ->withAction($this->router->generate('twilio.callback'));
```
## Payloads & ParamConverters

If you want to write your own controllers instead, then you can still make use of the ParamConverters and payload objects

The ParamConvertors will automatically create the request payload objects for you, if you use the correct type-hint:
```php
use Orukusaki\TwilioBundle\Payload\InboundCall;

public function inboundCallAction(InboundCall $call)
{
    return (new Response)->say('Hi, you are calling from ' . $payload->from);
}
```
