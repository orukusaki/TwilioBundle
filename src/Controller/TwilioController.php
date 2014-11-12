<?php

namespace Orukusaki\TwilioBundle\Controller;

use Orukusaki\TwilioBundle\Payload\CallStatus;
use Orukusaki\TwilioBundle\Payload\InboundCall;
use Orukusaki\TwilioBundle\Payload\Recording;
use Orukusaki\TwilioBundle\Payload\Sms;
use Orukusaki\TwilioBundle\TwilioEvent;
use Orukusaki\TwiML\Node;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request     $request
     *
     * @return Response
     */
    public function inboundCallAction(InboundCall $call, Request $request)
    {
        return $this->handle('inbound', $call, $request);
    }

    /**
     * @Route("/callback", name="twilio_callback")
     * @param CallStatus $status
     * @param Request    $request
     *
     * @return Response
     */
    public function statusCallbackAction(CallStatus $status, Request $request)
    {
        return $this->handle('status', $status, $request);
    }

    /**
     * @Route("/recording", name="twilio_recording")
     * @param Recording $recording
     *
     * @param Request   $request
     *
     * @return Response
     */
    public function recordingAction(Recording $recording, Request $request)
    {
        return $this->handle('recording', $recording, $request);
    }

    /**
     * @Route("/sms", name="twilio_sms")
     * @param Sms     $message
     * @param Request $request
     *
     * @return Response
     */
    public function smsAction(Sms $message, Request $request)
    {
        return $this->handle('sms', $message, $request);
    }

    /**
     * @param string  $key
     * @param mixed   $payload
     * @param Request $request
     *
     * @return Response
     */
    private function handle($key, $payload, Request $request)
    {
        $event = new TwilioEvent($payload);
        $event->query = $request->query->all();

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
