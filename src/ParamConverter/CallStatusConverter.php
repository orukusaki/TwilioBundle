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

        $event->callDuration = $request->get('CallDuration');
        $event->recordingUrl = $request->get('RecordingUrl');
        $event->recordingSid = $request->get('RecordingSid');
        $event->recordingDuration = $request->get('RecordingDuration');

        $request->attributes->set($configuration->getName(), $event);

        return false; // So the VoiceCallConverter also runs
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
