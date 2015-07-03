<?php

namespace Speicher210\CloudinaryBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 */
class Speicher210CloudinaryExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('speicher210_cloudinary.cloud_name', $config['cloud_name']);
        $container->setParameter('speicher210_cloudinary.access_identifier.api_key', $config['access_identifier']['api_key']);
        $container->setParameter('speicher210_cloudinary.access_identifier.api_secret', $config['access_identifier']['api_secret']);
    }
}
