<?php

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
     * {@inheritdoc}
     */
    protected function loadInternal(array $config, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        if (array_key_exists('url', $config)) {
            $url = parse_url($config['url']);

            if (array_key_exists('host', $url)) {
                $config['cloud_name'] = $url['host'];
            }

            if (array_key_exists('user', $url)) {
                $config['access_identifier']['api_key'] = $url['user'];
            }
            if (array_key_exists('pass', $url)) {
                $config['access_identifier']['api_secret'] = $url['pass'];
            }
        }

        if (!isset($config['cloud_name'], $config['access_identifier']['api_key'], $config['access_identifier']['api_secret'])) {
            throw new \InvalidArgumentException('Cloudinary URL not correctly set.');
        }

        $container
            ->getDefinition('speicher210_cloudinary.cloudinary')
            ->replaceArgument(
                0,
                [
                    'cloud_name' => $config['cloud_name'],
                    'api_key' => $config['access_identifier']['api_key'],
                    'api_secret' => $config['access_identifier']['api_secret'],
                ]
            );
    }
}
