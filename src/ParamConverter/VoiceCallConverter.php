<?php
namespace Orukusaki\TwilioBundle\ParamConverter;

use Orukusaki\TwilioBundle\Payload\VoiceCall;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class VoiceCallConverter implements ParamConverterInterface
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
        if (!$request->attributes->has($configuration->getName())) {
            return false;
        }

        $event = $request->attributes->get($configuration->getName());

        if (!$event instanceof VoiceCall) {
            return false;
        }

        $event->callSid = $request->get('CallSid');
        $event->accountSid = $request->get('AccountSid');
        $event->from = $request->get('From');
        $event->to = $request->get('To');
        $event->callStatus = $request->get('CallStatus');
        $event->apiVersion = $request->get('ApiVersion');
        $event->direction = $request->get('Direction');
        $event->forwardedFrom = $request->get('ForwardedFrom');
        $event->callerName = $request->get('CallerName');
        $event->fromCity = $request->get('FromCity');
        $event->fromState = $request->get('FromState');
        $event->fromZip = $request->get('FromZip');
        $event->fromCountry = $request->get('FromCountry');
        $event->toCity = $request->get('ToCity');
        $event->toState = $request->get('ToState');
        $event->toZip = $request->get('ToZip');
        $event->toCountry = $request->get('ToCountry');

        $event->query = $request->query->all();

        return true;
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
        return VoiceCall::class == $configuration->getClass()
            ||  is_subclass_of($configuration->getClass(), VoiceCall::class);
    }
}
