<?php

namespace Orukusaki\TwilioBundle;

use Orukusaki\TwiML\Node;
use Symfony\Component\EventDispatcher\Event;

/**
 * Interface TwilioEvent
 * @package Orukusaki\TwilioBundle\Payload
 */
class TwilioEvent extends Event
{
    /**
     * @var array
     */
    public $query = [];

    /**
     * @var Node
     */
    private $response;

    private $payload;

    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return Node
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Node $response
     */
    public function setResponse(Node $response)
    {
        $this->stopPropagation();
        $this->response = $response;
    }
}
