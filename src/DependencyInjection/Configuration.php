<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use function method_exists;

/**
 * This class contains the configuration information for the bundle.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('speicher210_cloudinary');
        $rootNode    = method_exists(TreeBuilder::class, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root('speicher210_cloudinary');

        $rootNode
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
