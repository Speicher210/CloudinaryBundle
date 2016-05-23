<?php

namespace Speicher210\CloudinaryBundle\Tests\DependencyInjection;

use Speicher210\CloudinaryBundle\DependencyInjection\Speicher210CloudinaryExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class AbstractSpeicher210CloudinaryExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->container->registerExtension($extension = new Speicher210CloudinaryExtension());
        $this->container->loadFromExtension($extension->getAlias());
    }

    /**
     * Loads a configuration.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container     The container.
     * @param string                                                  $configuration The configuration.
     */
    abstract protected function loadConfiguration(ContainerBuilder $container, $configuration);

    public function testCloudinaryService()
    {
        $this->loadConfiguration($this->container, 'default');
        $this->container->compile();

        $cloudinary = $this->container->get('speicher210_cloudinary.cloudinary');

        $this->assertInstanceOf('Speicher210\CloudinaryBundle\Cloudinary\Cloudinary', $cloudinary);
        $this->assertInstanceOf('Cloudinary', $cloudinary);

        $this->assertDefaultConfig();
    }

    public function testApiService()
    {
        $this->loadConfiguration($this->container, 'default');
        $this->container->compile();

        $api = $this->container->get('speicher210_cloudinary.api');

        $this->assertInstanceOf('Speicher210\CloudinaryBundle\Cloudinary\Api', $api);
        $this->assertInstanceOf('Cloudinary\Api', $api);

        $this->assertDefaultConfig();
    }

    public function testUploaderService()
    {
        $this->loadConfiguration($this->container, 'default');
        $this->container->compile();

        $uploader = $this->container->get('speicher210_cloudinary.uploader');

        $this->assertInstanceOf('Speicher210\CloudinaryBundle\Cloudinary\Uploader', $uploader);
        $this->assertInstanceOf('Cloudinary\Uploader', $uploader);

        $this->assertDefaultConfig();
    }

    public function testTwigExtensionService()
    {
        $this->loadConfiguration($this->container, 'default');
        $this->container->compile();

        $service = 'twig.extension.cloudinary';

        $this->assertInstanceOf(
            'Speicher210\CloudinaryBundle\Twig\Extension\CloudinaryExtension',
            $this->container->get($service)
        );

        $this->assertTrue($this->container->getDefinition($service)->hasTag('twig.extension'));
        $this->assertDefaultConfig();
    }

    /**
     * Asserts that the default configuration has been populated.
     */
    private function assertDefaultConfig()
    {
        $this->assertSame(array(
            'cloud_name' => 'name',
            'api_key' => 'key',
            'api_secret' => 'secret',
        ), \Cloudinary::config());
    }
}
