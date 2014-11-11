<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class TestKernel extends Kernel
{
    private $extraConfigs = [];

    private $containerClass = '';

    public function registerBundles()
    {
        return [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Orukusaki\TwilioBundle\OrukusakiTwilioBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config_test.yml');

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
        if (!$this->containerClass) {
            $this->containerClass = $this->name . spl_object_hash($this) . 'ProjectContainer';
        }

        return $this->containerClass;
    }

    public function addConfig($config)
    {
        $filename = tempnam(sys_get_temp_dir(), 'config') . '.yml';
        file_put_contents($filename, $config);

        $this->extraConfigs[] = $filename;
    }

    public function getCacheDir()
    {
        return sys_get_temp_dir() . '/cache';
    }

    public function getLogDir()
    {
        return sys_get_temp_dir() . '/logs';
    }
}
