<?php
namespace Orukusaki\TwilioBundle\Fixture;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class MockKernel
 * @package Orukusaki\TwilioBundle\Fixture
 */
class MockKernel extends Kernel
{
    /**
     * @var array
     */
    private $extraConfigs = [];

    /**
     * @return array
     */
    public function registerBundles()
    {
        return [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new \Orukusaki\TwilioBundle\OrukusakiTwilioBundle(),
        ];
    }

    /**
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config_test.yml');

        foreach ($this->extraConfigs as $filename) {
            $loader->load($filename);
        }
    }

    /**
     * Gets the container class.
     *
     * Uses the object hash to ensure a unique container for every instance
     *
     * @return string The container class
     */
    protected function getContainerClass()
    {
        return $this->name . spl_object_hash($this) . 'ProjectContainer';
    }

    /**
     * @param $config
     */
    public function addConfig($config)
    {
        $filename = tempnam(sys_get_temp_dir(), 'config') . '.yml';
        file_put_contents($filename, $config);

        $this->extraConfigs[] = $filename;
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return sys_get_temp_dir() . '/cache';
    }

    /**
     * @return string
     */
    public function getLogDir()
    {
        return sys_get_temp_dir() . '/logs';
    }
}
