<?php

namespace Orukusaki\TwilioBundle\Controller;

use Orukusaki\TwilioBundle\Payload\CallStatus;
use Orukusaki\TwilioBundle\Payload\InboundCall;
use Orukusaki\TwilioBundle\Payload\Recording;
use Orukusaki\TwilioBundle\Payload\Sms;
use Orukusaki\TwilioBundle\TwilioEvent;
use Orukusaki\TwiML\Node;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class TwilioController
 * @Route(service="twilio.controller")
 */
class TwilioController
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/inbound", name="twilio_inbound")
     * @param InboundCall $call
     *
     * @return Response
     */
    public function inboundCallAction(InboundCall $call)
    {
        return $this->handle($call, 'inbound');
    }

    /**
     * @Route("/callback", name="twilio_callback")
     * @param CallStatus $status
     *
     * @return Response
     */
    public function statusCallbackAction(CallStatus $status)
    {
        return $this->handle($status, 'status');
    }

    /**
     * @Route("/recording", name="twilio_recording")
     * @param Recording $recording
     *
     * @return Response
     */
    public function recordingAction(Recording $recording)
    {
        return $this->handle($recording, 'recording');
    }

    /**
     * @Route("/sms", name="twilio_sms")
     * @param Sms $message
     *
     * @return Response
     */
    public function smsAction(Sms $message)
    {
        return $this->handle($message, 'sms');
    }

    /**
     * @param mixed  $payload
     * @param string $key
     *
     * @return Response
     */
    private function handle($payload, $key)
    {
        $event = new TwilioEvent($payload);

        $this->dispatcher->dispatch("twilio.$key", $event);

        return $this->createResponse($event->getResponse());
    }

    /**
     * @param Node $twiml
     *
     * @return Response
     */
    private function createResponse(Node $twiml = null)
    {
        $response = new Response($twiml);
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
