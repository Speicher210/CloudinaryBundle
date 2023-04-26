<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Tests\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class YamlSpeicher210CloudinaryExtensionTest extends AbstractSpeicher210CloudinaryExtensionTest
{
    protected function loadConfiguration(ContainerBuilder $container, string $configuration): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Fixtures/Config/Yaml'));
        $loader->load($configuration . '.yml');
    }
}
