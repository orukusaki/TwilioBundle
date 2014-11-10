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
            new Orukusaki\TwilioBundle\OrukusakiTwilioBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config_test.yml');

        foreach ($this->extraConfigs as $extraConfigContent) {
            $filename = tempnam(sys_get_temp_dir(), 'config') . '.yml';
            file_put_contents($filename, $extraConfigContent);
            $loader->load($filename);
        }
    }

    /**
     * Gets the container class.
     *
     * @return string The container class
     */
    protected function getContainerClass()
    {
        if (!$this->containerClass) {
            $this->containerClass = $this->name . md5(uniqid()) . 'ProjectContainer';
        }

        return $this->containerClass;
    }

    public function addConfig($config)
    {
        $this->extraConfigs[] = $config;
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
