<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Orukusaki\TwilioBundle\Fixture\MockKernel;
use Orukusaki\TwilioBundle\Payload\CallStatus;
use Orukusaki\TwilioBundle\Payload\InboundCall;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * @var MockKernel
     */
    private $kernel;

    /**
     * @var array
     */
    private $events = [];

    /**
     * @var Response
     */
    private $response;

    public function __construct()
    {
        require_once __DIR__ . '/bootstrap.php';
    }

    /**
     * @BeforeScenario
     */
    public function setUp()
    {
        $this->kernel = new MockKernel('test', true);
    }

    /**
     * @AfterScenario
     */
    public function testDown()
    {
        $this->kernel->shutdown();
    }

    /**
     * @Given an app config with:
     */
    public function anAppConfigWith(PyStringNode $config)
    {
        $this->kernel->addConfig((string) $config);
    }

    /**
     * @Given I have not added twilio config
     */
    public function iHaveNotAddedTwilioConfig()
    {
        // do nothing
    }

    /**
     * @When the app is booted
     */
    public function theAppIsBooted()
    {
        $this->kernel->boot();
    }

    /**
     * @Then there should be a twilio client available in the service container
     */
    public function thereShouldBeATwilioClientAvailableInTheServiceContainer()
    {
        $container = $this->kernel->getContainer();

        expect($container->has('twilio.client'))->toBe(true);
    }

    /**
     * @Then there should not be a twilio client available in the service container
     */
    public function thereShouldNotBeATwilioClientAvailableInTheServiceContainer()
    {
        $container = $this->kernel->getContainer();

        expect($container->has('twilio.client'))->toBe(false);
    }
    /**
     * @Given I have registered an incoming call listener
     */
    public function iHaveRegisteredAnIncomingCallListener()
    {
        $this->aListenerIsRegistered('twilio.inbound');
    }

    /**
     * @When an inbound call is received with the params:
     */
    public function anInboundCallIsReceivedWithTheParams(TableNode $table)
    {
        $this->aRequestIsReceived('/twilio/inbound', $table);
    }

    /**
     * @Then the payload should be an inbound call
     */
    public function thePayloadShouldBeAnInboundCall()
    {
        $payload = $this->events[0]->getPayload();

        expect($payload)->toBeAnInstanceOf(InboundCall::class);
    }

    /**
     * @Then the payload should have fields:
     */
    public function thePayloadShouldHaveFields(TableNode $table)
    {
        $payload = $this->events[0]->getPayload();
        foreach ($table->getHash() as $row) {
            expect($payload->{$row['Var']})->toBe($row['Value']);
        }
    }

    /**
     * @Then the listener should be called
     */
    public function theListenerShouldBeCalled()
    {
        expect($this->events)->toHaveCount(1);
    }

    /**
     * @Given I have registered a call status listener
     */
    public function iHaveRegisteredACallStatusListener()
    {
        $this->aListenerIsRegistered('twilio.status');
    }

    /**
     * @When a call status is received with the params:
     */
    public function aCallStatusIsReceived(TableNode $table)
    {
        $this->aRequestIsReceived('/twilio/callback', $table);
    }

    /**
     * @Then the payload should be a call status
     */
    public function thePayloadShouldBeACallStatus()
    {
        $payload = $this->events[0]->getPayload();

        expect($payload)->toBeAnInstanceOf(CallStatus::class);
    }

    /**
     * @param $eventName
     */
    private function aListenerIsRegistered($eventName)
    {
        $this->kernel->boot();
        $dispatcher = $this->kernel->getContainer()->get('event_dispatcher');

        /** @var EventDispatcher $dispatcher */
        $dispatcher->addListener($eventName, [$this, 'observeEvent']);
    }

    /**
     * @param           $path
     * @param TableNode $table
     */
    private function aRequestIsReceived($path, TableNode $table)
    {
        $params = [];
        foreach ($table->getHash() as $row) {
            $params[$row['Param']] = $row['Value'];
        }
        $request = Request::create(
            $path,
            'POST',
            $params
        );

        $this->response = $this->kernel->handle($request);
    }

    /**
     * @param $event
     */
    public function observeEvent($event)
    {
        $this->events[] = $event;
    }
}
