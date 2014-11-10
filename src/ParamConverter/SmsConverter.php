<?php

namespace Orukusaki\TwilioBundle\ParamConverter;

use Orukusaki\TwilioBundle\Payload\Sms;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class SmsConverter implements ParamConverterInterface
{
    /**
     * Stores the object in the request.
     *
     * @param Request        $request       The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool    True if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $event = new Sms;

        $event->messageSid = $request->get('CallSid');
        $event->smsSid = $request->get('AccountSid');
        $event->accountSid = $request->get('From');
        $event->from = $request->get('To');
        $event->to = $request->get('CallStatus');
        $event->body = $request->get('ApiVersion');
        $event->numMedia = $request->get('Direction');

        for ($i = 0; $i <= $event->numMedia; $i++) {
            $event->mediaContentType[$i] = $request->get('MediaContentType'.$i);
            $event->mediaUrl[$i] = $request->get('MediaUrl'.$i);
        }

        $event->fromCity = $request->get('Direction');
        $event->fromState = $request->get('Direction');
        $event->fromZip = $request->get('Direction');
        $event->fromCountry = $request->get('Direction');
        $event->toCity = $request->get('Direction');
        $event->toState = $request->get('Direction');
        $event->toZip = $request->get('Direction');
        $event->toCountry = $request->get('Direction');

        $event->query = $request->query->all();

        $request->attributes->set($configuration->getName(), $event);
    }

    /**
     * Checks if the object is supported.
     *
     * @param ParamConverter $configuration Should be an instance of ParamConverter
     *
     * @return bool    True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        return Sms::class == $configuration->getClass();
    }
} 
