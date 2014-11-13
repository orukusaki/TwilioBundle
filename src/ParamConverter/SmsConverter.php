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

        $sms->messageSid = $request->get('MessageSid');
        $sms->smsSid = $request->get('SmsSid');
        $sms->accountSid = $request->get('AccountSid');
        $sms->from = $request->get('From');
        $sms->to = $request->get('To');
        $sms->body = $request->get('Body');
        $sms->numMedia = $request->get('NumMedia');

        for ($i = 0; $i < $sms->numMedia; $i++) {
            $sms->mediaContentType[$i] = $request->get('MediaContentType'.$i);
            $sms->mediaUrl[$i] = $request->get('MediaUrl'.$i);
        }

        $sms->fromCity = $request->get('FromCity');
        $sms->fromState = $request->get('FromState');
        $sms->fromZip = $request->get('FromZip');
        $sms->fromCountry = $request->get('FromCountry');
        $sms->toCity = $request->get('ToCity');
        $sms->toState = $request->get('ToState');
        $sms->toZip = $request->get('ToZip');
        $sms->toCountry = $request->get('ToCountry');

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
