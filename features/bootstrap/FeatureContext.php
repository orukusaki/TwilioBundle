<?php
require_once __DIR__ . '/app/autoload.php';

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * @var TestKernel
     */
    private $kernel;

    /**
     * @BeforeScenario
     */
    public function setUp()
    {
        $this->kernel = new TestKernel('test', true);
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
}
