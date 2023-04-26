<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\DependencyInjection;

use Speicher210\CloudinaryBundle\Factory\CloudinaryFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

final class Speicher210CloudinaryExtension extends ConfigurableExtension
{
    /**
     * @param array<mixed> $mergedConfig
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $container
            ->getDefinition(CloudinaryFactory::class)
            ->replaceArgument(0, $mergedConfig);
    }
}
