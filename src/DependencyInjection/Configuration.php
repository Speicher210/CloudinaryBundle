<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle.
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('speicher210_cloudinary');
        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('url')
                    ->info('Any parameter value parsed from this string will override explicitly set parameters.')
                ->end()
                ->scalarNode('cloud_name')
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('access_identifier')
                    ->children()
                        ->scalarNode('api_key')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('api_secret')
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('options')
                  ->prototype('variable')->end()
                ->end();

        return $treeBuilder;
    }
}
