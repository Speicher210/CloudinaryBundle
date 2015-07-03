<?php

namespace Speicher210\CloudinaryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('speicher210_cloudinary');

        $rootNode
            ->children()
                ->scalarNode('cloud_name')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('access_identifier')
                    ->isRequired()
                    ->children()
                        ->scalarNode('api_key')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('api_secret')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
        ;

        return $treeBuilder;
    }
}
