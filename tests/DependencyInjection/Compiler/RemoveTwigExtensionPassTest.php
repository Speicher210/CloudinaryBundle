<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Tests\DependencyInjection\Compiler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Speicher210\CloudinaryBundle\DependencyInjection\Compiler\RemoveTwigExtensionPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RemoveTwigExtensionPassTest extends TestCase
{
    /** @var MockObject|ContainerBuilder|(ContainerBuilder&MockObject) */
    private $container;

    private RemoveTwigExtensionPass $compilerPass;

    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerBuilder::class);

        $this->compilerPass = new RemoveTwigExtensionPass();
    }

    public function testProcessWithTwig(): void
    {
        $this->container
            ->expects(self::once())
            ->method('hasDefinition')
            ->with('twig')
            ->willReturn(true);

        $this->container
            ->expects(self::never())
            ->method('removeDefinition')
            ->with('twig.extension.cloudinary');

        $this->compilerPass->process($this->container);
    }

    public function testProcessWithoutTwig(): void
    {
        $this->container
            ->expects(self::once())
            ->method('hasDefinition')
            ->with('twig')
            ->willReturn(false);

        $this->container
            ->expects(self::once())
            ->method('removeDefinition')
            ->with('twig.extension.cloudinary');

        $this->compilerPass->process($this->container);
    }
}
