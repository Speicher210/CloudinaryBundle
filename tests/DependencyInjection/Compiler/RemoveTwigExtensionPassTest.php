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
        $this->container = $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['hasDefinition', 'removeDefinition'])
            ->getMock();

        $this->compilerPass = new RemoveTwigExtensionPass();
    }

    public function testProcessWithTwig(): void
    {
        $this->container
            ->expects($this->once())
            ->method('hasDefinition')
            ->with($this->identicalTo('twig'))
            ->will($this->returnValue(true));

        $this->container
            ->expects($this->never())
            ->method('removeDefinition')
            ->with($this->identicalTo('twig.extension.cloudinary'));

        $this->compilerPass->process($this->container);
    }

    public function testProcessWithoutTwig(): void
    {
        $this->container
            ->expects($this->once())
            ->method('hasDefinition')
            ->with($this->identicalTo('twig'))
            ->will($this->returnValue(false));

        $this->container
            ->expects($this->once())
            ->method('removeDefinition')
            ->with($this->identicalTo('twig.extension.cloudinary'));

        $this->compilerPass->process($this->container);
    }
}
