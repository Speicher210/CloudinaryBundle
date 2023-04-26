<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * This is the class that loads and manages your bundle configuration.
 */
class Speicher210CloudinaryExtension extends ConfigurableExtension
{
    /**
     * {@inheritDoc}
     */
    protected function loadInternal(array $config, ContainerBuilder $container): void
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $container
            ->getDefinition('speicher210_cloudinary.cloudinary')
            ->replaceArgument(0, $config);
    }
}
