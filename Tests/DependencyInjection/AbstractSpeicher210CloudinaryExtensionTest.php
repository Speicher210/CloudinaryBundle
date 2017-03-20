<?php

namespace Speicher210\CloudinaryBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Speicher210\CloudinaryBundle\DependencyInjection\Speicher210CloudinaryExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Speicher210\CloudinaryBundle\Cloudinary\Cloudinary;
use Speicher210\CloudinaryBundle\Cloudinary\Api;
use Speicher210\CloudinaryBundle\Cloudinary\Uploader;
use Speicher210\CloudinaryBundle\Twig\Extension\CloudinaryExtension;

abstract class AbstractSpeicher210CloudinaryExtensionTest extends TestCase
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
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container The container.
     * @param string $configuration The configuration.
     */
    abstract protected function loadConfiguration(ContainerBuilder $container, $configuration);

    public function testURLConfigurationOverwritesParameters()
    {
        $this->loadConfiguration($this->container, 'with_url');
        $this->container->compile();

        // Need to trigger a load.
        $this->container->get('speicher210_cloudinary.cloudinary');

        $this->assertDefaultConfig();
    }

    public function testCloudinaryService()
    {
        $this->loadConfiguration($this->container, 'default');
        $this->container->compile();

        $cloudinary = $this->container->get('speicher210_cloudinary.cloudinary');

        static::assertInstanceOf(Cloudinary::class, $cloudinary);
        static::assertInstanceOf(\Cloudinary::class, $cloudinary);

        $this->assertDefaultConfig();
    }

    public function testApiService()
    {
        $this->loadConfiguration($this->container, 'default');
        $this->container->compile();

        $api = $this->container->get('speicher210_cloudinary.api');

        static::assertInstanceOf(Api::class, $api);
        static::assertInstanceOf(\Cloudinary\Api::class, $api);

        $this->assertDefaultConfig();
    }

    public function testUploaderService()
    {
        $this->loadConfiguration($this->container, 'default');
        $this->container->compile();

        $uploader = $this->container->get('speicher210_cloudinary.uploader');

        static::assertInstanceOf(Uploader::class, $uploader);
        static::assertInstanceOf(\Cloudinary\Uploader::class, $uploader);

        $this->assertDefaultConfig();
    }

    public function testTwigExtensionService()
    {
        $this->loadConfiguration($this->container, 'default');
        $this->container->compile();

        $service = 'twig.extension.cloudinary';

        static::assertInstanceOf(
            CloudinaryExtension::class,
            $this->container->get($service)
        );

        static::assertTrue($this->container->getDefinition($service)->hasTag('twig.extension'));
        $this->assertDefaultConfig();
    }

    /**
     * Asserts that the default configuration has been populated.
     */
    private function assertDefaultConfig()
    {
        static::assertSame(
            [
                'cloud_name' => 'name',
                'api_key' => 'key',
                'api_secret' => 'secret',
            ],
            \Cloudinary::config()
        );
    }
}
