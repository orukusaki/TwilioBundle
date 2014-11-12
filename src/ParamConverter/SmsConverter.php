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
        $sms = new Sms;

        $sms->messageSid = $request->get('CallSid');
        $sms->smsSid = $request->get('AccountSid');
        $sms->accountSid = $request->get('From');
        $sms->from = $request->get('To');
        $sms->to = $request->get('CallStatus');
        $sms->body = $request->get('ApiVersion');
        $sms->numMedia = $request->get('Direction');

        for ($i = 0; $i <= $sms->numMedia; $i++) {
            $sms->mediaContentType[$i] = $request->get('MediaContentType'.$i);
            $sms->mediaUrl[$i] = $request->get('MediaUrl'.$i);
        }

        $sms->fromCity = $request->get('Direction');
        $sms->fromState = $request->get('Direction');
        $sms->fromZip = $request->get('Direction');
        $sms->fromCountry = $request->get('Direction');
        $sms->toCity = $request->get('Direction');
        $sms->toState = $request->get('Direction');
        $sms->toZip = $request->get('Direction');
        $sms->toCountry = $request->get('Direction');

        $request->attributes->set($configuration->getName(), $sms);
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
