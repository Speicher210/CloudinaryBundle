<?php

namespace Speicher210\CloudinaryBundle\Tests\DependencyInjection\Compiler;

use Speicher210\CloudinaryBundle\DependencyInjection\Compiler\RemoveTwigExtensionPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RemoveTwigExtensionPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ContainerBuilder
     */
    private $container;

    /**
     * @var RemoveTwigExtensionPass
     */
    private $compilerPass;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->container = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->setMethods(array('hasDefinition', 'removeDefinition'))
            ->getMock();

        $this->compilerPass = new RemoveTwigExtensionPass();
    }

    public function testProcessWithTwig()
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

    public function testProcessWithoutTwig()
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
