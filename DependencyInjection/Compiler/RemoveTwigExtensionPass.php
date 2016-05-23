<?php

namespace Speicher210\CloudinaryBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * This class removes the Twig extension if Twig is not available.
 */
class RemoveTwigExtensionPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('twig')) {
            $container->removeDefinition('twig.extension.cloudinary');
        }
    }
}
