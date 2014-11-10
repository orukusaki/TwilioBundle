<?php
namespace Orukusaki\TwilioBundle\ParamConverter;

use Orukusaki\TwilioBundle\Payload\CallStatus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class CallStatusConverter implements ParamConverterInterface
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
        $event = new CallStatus;

        $event->dialCallStatus = $request->get('DialCallStatus');
        $event->dialCallSid = $request->get('DialCallSid');
        $event->dialCallDuration = $request->get('DialCallDuration');
        $event->recordingUrl = $request->get('RecordingUrl');

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
        return CallStatus::class == $configuration->getClass();
    }
}
