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

        $call = $request->attributes->get($configuration->getName());

        if (!$call instanceof VoiceCall) {
            return false;
        }

        $call->callSid = $request->get('CallSid');
        $call->accountSid = $request->get('AccountSid');
        $call->from = $request->get('From');
        $call->to = $request->get('To');
        $call->callStatus = $request->get('CallStatus');
        $call->apiVersion = $request->get('ApiVersion');
        $call->direction = $request->get('Direction');
        $call->forwardedFrom = $request->get('ForwardedFrom');
        $call->callerName = $request->get('CallerName');
        $call->fromCity = $request->get('FromCity');
        $call->fromState = $request->get('FromState');
        $call->fromZip = $request->get('FromZip');
        $call->fromCountry = $request->get('FromCountry');
        $call->toCity = $request->get('ToCity');
        $call->toState = $request->get('ToState');
        $call->toZip = $request->get('ToZip');
        $call->toCountry = $request->get('ToCountry');

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
