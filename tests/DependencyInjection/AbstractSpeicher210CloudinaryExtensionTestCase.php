<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Tests\DependencyInjection;

use Cloudinary\Configuration\Configuration;
use PHPUnit\Framework\TestCase;
use Speicher210\CloudinaryBundle\Cloudinary\Admin;
use Speicher210\CloudinaryBundle\Cloudinary\Cloudinary;
use Speicher210\CloudinaryBundle\Cloudinary\Uploader;
use Speicher210\CloudinaryBundle\DependencyInjection\Speicher210CloudinaryExtension;
use Speicher210\CloudinaryBundle\Twig\Extension\CloudinaryExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class AbstractSpeicher210CloudinaryExtensionTestCase extends TestCase
{
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->container = new ContainerBuilder();
        $this->container->registerExtension($extension = new Speicher210CloudinaryExtension());
        $this->container->loadFromExtension($extension->getAlias());
    }

    /**
     * Loads a configuration.
     *
     * @param ContainerBuilder $container     The container.
     * @param string           $configuration The configuration.
     */
    abstract protected function loadConfiguration(ContainerBuilder $container, string $configuration): void;

    public function testURLConfigurationOverwritesParameters(): void
    {
        $this->loadConfiguration($this->container, 'with_url');
        $this->container->compile();

        // Need to trigger a load.
        $service = $this->container->get('speicher210_cloudinary.cloudinary');

        static::assertInstanceOf(Cloudinary::class, $service);

        $this->assertDefaultConfig($service->configuration);
    }

    public function testCloudinaryService(): void
    {
        $this->loadConfiguration($this->container, 'default');
        $this->container->compile();

        $cloudinary = $this->container->get('speicher210_cloudinary.cloudinary');

        static::assertInstanceOf(Cloudinary::class, $cloudinary);

        $this->assertDefaultConfig($cloudinary->configuration);
    }

    public function testUploaderService(): void
    {
        $this->loadConfiguration($this->container, 'default');
        $this->container->compile();

        $uploader = $this->container->get('speicher210_cloudinary.uploader');

        static::assertInstanceOf(Uploader::class, $uploader);

        $this->assertDefaultConfig($uploader->configuration);
    }

    public function testAdminService(): void
    {
        $this->loadConfiguration($this->container, 'default');
        $this->container->compile();

        $admin = $this->container->get('speicher210_cloudinary.admin');

        static::assertInstanceOf(Admin::class, $admin);

        $this->assertDefaultConfig($admin->configuration);
    }

    public function testTwigExtensionService(): void
    {
        $this->loadConfiguration($this->container, 'default');
        $this->container->compile();

        $service = 'twig.extension.cloudinary';

        static::assertInstanceOf(CloudinaryExtension::class, $this->container->get($service));

        static::assertTrue($this->container->getDefinition($service)->hasTag('twig.extension'));
    }

    /**
     * Asserts that the default configuration has been populated.
     */
    private function assertDefaultConfig(Configuration $configuration): void
    {
        static::assertTrue($configuration->url->secure);
        static::assertSame(
            [
                'cloud_name' => 'name',
                'api_key' => 'key',
                'api_secret' => 'secret',
            ],
            [
                'cloud_name' => $configuration->cloud->cloudName,
                'api_key' => $configuration->cloud->apiKey,
                'api_secret' => $configuration->cloud->apiSecret,
            ],
        );
    }
}
