<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * This class removes the Twig extension if Twig is not available.
 */
class RemoveTwigExtensionPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('twig')) {
            return;
        }

        $container->removeDefinition('twig.extension.cloudinary');
    }
}
