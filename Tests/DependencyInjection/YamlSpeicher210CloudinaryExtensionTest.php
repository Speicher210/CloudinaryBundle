<?php

namespace Speicher210\CloudinaryBundle\Tests\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class YamlSpeicher210CloudinaryExtensionTest extends AbstractSpeicher210CloudinaryExtensionTest
{
    /**
     * {@inheritdoc}
     */
    protected function loadConfiguration(ContainerBuilder $container, $configuration)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Fixtures/Config/Yaml'));
        $loader->load($configuration.'.yml');
    }
}
