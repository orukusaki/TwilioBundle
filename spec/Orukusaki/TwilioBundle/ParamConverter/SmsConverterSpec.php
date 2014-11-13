<?php

namespace spec\Orukusaki\TwilioBundle\ParamConverter;

use Orukusaki\TwilioBundle\ParamConverter\SmsConverter;
use Orukusaki\TwilioBundle\Payload\Sms;
use Orukusaki\TwilioBundle\Payload\Recording;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * @mixin SmsConverter
 */
class SmsConverterSpec extends ObjectBehavior
{
    function it_is_a_param_converter()
    {
        $this->shouldBeAnInstanceOf(ParamConverterInterface::class);
    }

    function it_supports_call_status(ParamConverter $configuration)
    {
        $configuration->getClass()->willReturn(Sms::class);

        $this->supports($configuration)->shouldBe(true);
    }

    function it_does_not_support_others(ParamConverter $configuration)
    {
        $configuration->getClass()->willReturn(Recording::class);

        $this->supports($configuration)->shouldBe(false);
    }

    function it_adds_object_with_params_set(Request $request, ParamConverter $configuration, ParameterBag $attributes)
    {
        $request->get('MessageSid')->willReturn('MessageSidValue');
        $request->get('SmsSid')->willReturn('SmsSidValue');
        $request->get('AccountSid')->willReturn('AccountSidValue');
        $request->get('From')->willReturn('FromValue');
        $request->get('To')->willReturn('ToValue');
        $request->get('Body')->willReturn('BodyValue');
        $request->get('NumMedia')->willReturn(0);
        $request->get('FromCity')->willReturn('FromCityValue');
        $request->get('FromState')->willReturn('FromStateValue');
        $request->get('FromZip')->willReturn('FromZipValue');
        $request->get('FromCountry')->willReturn('FromCountryValue');
        $request->get('ToCity')->willReturn('ToCityValue');
        $request->get('ToState')->willReturn('ToStateValue');
        $request->get('ToZip')->willReturn('ToZipValue');
        $request->get('ToCountry')->willReturn('ToCountryValue');

        $request->attributes = $attributes;

        $configuration->getName()->willReturn('varName');

        $sms = new Sms;

        $sms->messageSid = 'MessageSidValue';
        $sms->smsSid = 'SmsSidValue';
        $sms->accountSid = 'AccountSidValue';
        $sms->from = 'FromValue';
        $sms->to = 'ToValue';
        $sms->body = 'BodyValue';
        $sms->numMedia = 0;
        $sms->fromCity = 'FromCityValue';
        $sms->fromState = 'FromStateValue';
        $sms->fromZip = 'FromZipValue';
        $sms->fromCountry = 'FromCountryValue';
        $sms->toCity = 'ToCityValue';
        $sms->toState = 'ToStateValue';
        $sms->toZip = 'ToZipValue';
        $sms->toCountry = 'ToCountryValue';

        $this->apply($request, $configuration);

        $attributes->set('varName', $sms)->shouldHaveBeenCalled();
    }


    function it_adds_object_with_media(Request $request, ParamConverter $configuration, ParameterBag $attributes)
    {
        $request->get('MessageSid')->willReturn('MessageSidValue');
        $request->get('SmsSid')->willReturn('SmsSidValue');
        $request->get('AccountSid')->willReturn('AccountSidValue');
        $request->get('From')->willReturn('FromValue');
        $request->get('To')->willReturn('ToValue');
        $request->get('Body')->willReturn('BodyValue');
        $request->get('FromCity')->willReturn('FromCityValue');
        $request->get('FromState')->willReturn('FromStateValue');
        $request->get('FromZip')->willReturn('FromZipValue');
        $request->get('FromCountry')->willReturn('FromCountryValue');
        $request->get('ToCity')->willReturn('ToCityValue');
        $request->get('ToState')->willReturn('ToStateValue');
        $request->get('ToZip')->willReturn('ToZipValue');
        $request->get('ToCountry')->willReturn('ToCountryValue');

        $request->get('NumMedia')->willReturn(2);

        $request->get('MediaContentType0')->willReturn('ContentType0');
        $request->get('MediaContentType1')->willReturn('ContentType1');

        $request->get('MediaUrl0')->willReturn('Url0');
        $request->get('MediaUrl1')->willReturn('Url1');

        $request->attributes = $attributes;

        $configuration->getName()->willReturn('varName');

        $sms = new Sms;

        $sms->messageSid = 'MessageSidValue';
        $sms->smsSid = 'SmsSidValue';
        $sms->accountSid = 'AccountSidValue';
        $sms->from = 'FromValue';
        $sms->to = 'ToValue';
        $sms->body = 'BodyValue';
        $sms->numMedia = 2;
        $sms->fromCity = 'FromCityValue';
        $sms->fromState = 'FromStateValue';
        $sms->fromZip = 'FromZipValue';
        $sms->fromCountry = 'FromCountryValue';
        $sms->toCity = 'ToCityValue';
        $sms->toState = 'ToStateValue';
        $sms->toZip = 'ToZipValue';
        $sms->toCountry = 'ToCountryValue';

        $sms->mediaContentType = [
            'ContentType0',
            'ContentType1',
        ];

        $sms->mediaUrl = [
            'Url0',
            'Url1',
        ];

        $this->apply($request, $configuration);

        $attributes->set('varName', $sms)->shouldHaveBeenCalled();
    }
}
