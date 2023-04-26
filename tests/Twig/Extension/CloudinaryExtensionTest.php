<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Speicher210\CloudinaryBundle\Cloudinary\Cloudinary;
use Speicher210\CloudinaryBundle\Twig\Extension\CloudinaryExtension;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class CloudinaryExtensionTest extends TestCase
{
    private Environment $twig;

    private CloudinaryExtension $extension;

    private Cloudinary $cloudinary;

    protected function setUp(): void
    {
        $this->cloudinary = new Cloudinary(['cloud_name' => 'test']);
        $this->extension  = new CloudinaryExtension($this->cloudinary);

        $this->twig = new Environment(new FilesystemLoader());
        $this->twig->addExtension($this->extension);
    }

    public function testUrlFunction(): void
    {
        $template = $this->twig->createTemplate('{{ cloudinary_url(url) }}');

        self::assertSame(
            'http://res.cloudinary.com/test/image/upload/id',
            $template->render(['url' => 'id']),
        );
    }

    public function testUrlFilter(): void
    {
        $template = $this->twig->createTemplate('{{ url | cloudinary_url }}');

        self::assertSame(
            'http://res.cloudinary.com/test/image/upload/id',
            $template->render(['url' => 'id']),
        );
    }

    public function testImageTagFunction(): void
    {
        $template = $this->twig->createTemplate('{{ cloudinary_image_tag(url) }}');

        self::assertSame(
            '<img src=\'http://res.cloudinary.com/test/image/upload/id\' />',
            $template->render(['url' => 'id']),
        );
    }

    public function testImageTagFilter(): void
    {
        $template = $this->twig->createTemplate('{{ url | cloudinary_image_tag }}');

        self::assertSame(
            '<img src=\'http://res.cloudinary.com/test/image/upload/id\' />',
            $template->render(['url' => 'id']),
        );
    }

    public function testVideoTagFunction(): void
    {
        $template = $this->twig->createTemplate('{{ cloudinary_video_tag(url) }}');

        self::assertSame(
            '<video poster=\'http://res.cloudinary.com/test/video/upload/id.jpg\'><source src=\'http://res.cloudinary.com/test/video/upload/id.webm\' type=\'video/webm\'><source src=\'http://res.cloudinary.com/test/video/upload/id.mp4\' type=\'video/mp4\'><source src=\'http://res.cloudinary.com/test/video/upload/id.ogv\' type=\'video/ogg\'></video>',
            $template->render(['url' => 'id']),
        );
    }

    public function testVideoTagFilter(): void
    {
        $template = $this->twig->createTemplate('{{ url | cloudinary_video_tag }}');

        self::assertSame(
            '<video poster=\'http://res.cloudinary.com/test/video/upload/id.jpg\'><source src=\'http://res.cloudinary.com/test/video/upload/id.webm\' type=\'video/webm\'><source src=\'http://res.cloudinary.com/test/video/upload/id.mp4\' type=\'video/mp4\'><source src=\'http://res.cloudinary.com/test/video/upload/id.ogv\' type=\'video/ogg\'></video>',
            $template->render(['url' => 'id']),
        );
    }
}
