<?php

namespace spec\Orukusaki\TwilioBundle\ParamConverter;

use Orukusaki\TwilioBundle\ParamConverter\CallStatusConverter;
use Orukusaki\TwilioBundle\Payload\CallStatus;
use Orukusaki\TwilioBundle\Payload\Recording;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * @mixin CallStatusConverter
 */
class CallStatusConverterSpec extends ObjectBehavior
{
    function it_is_a_param_converter()
    {
        $this->shouldBeAnInstanceOf(ParamConverterInterface::class);
    }

    function it_supports_call_status(ParamConverter $configuration)
    {
        $configuration->getClass()->willReturn(CallStatus::class);

        $this->supports($configuration)->shouldBe(true);
    }

    function it_does_not_support_others(ParamConverter $configuration)
    {
        $configuration->getClass()->willReturn(Recording::class);

        $this->supports($configuration)->shouldBe(false);
    }

    function it_adds_object_with_params_set(Request $request, ParamConverter $configuration, ParameterBag $attributes)
    {
        $request->get('CallDuration')->willReturn('CallDurationValue');
        $request->get('RecordingUrl')->willReturn('RecordingUrlValue');
        $request->get('RecordingSid')->willReturn('RecordingSidValue');
        $request->get('RecordingDuration')->willReturn('RecordingDurationValue');

        $request->attributes = $attributes;

        $configuration->getName()->willReturn('varName');

        $status = new CallStatus();
        $status->callDuration = 'CallDurationValue';
        $status->recordingUrl = 'RecordingUrlValue';
        $status->recordingSid = 'RecordingSidValue';
        $status->recordingDuration = 'RecordingDurationValue';

        $this->apply($request, $configuration);

        $attributes->set('varName', $status)->shouldHaveBeenCalled();
    }
}
