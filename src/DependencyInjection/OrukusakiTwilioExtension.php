<?php

namespace Orukusaki\TwilioBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class OrukusakiTwilioExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if (!isset($config['client'])) {
            $container->removeDefinition('twilio.client');
            return;
        }
        $client = $container->getDefinition('twilio.client');
        $client->replaceArgument(0, $config['client']['account_id']);
        $client->replaceArgument(1, $config['client']['token']);
    }
}
