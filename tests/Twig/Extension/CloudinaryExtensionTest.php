<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Speicher210\CloudinaryBundle\Cloudinary\Cloudinary;
use Speicher210\CloudinaryBundle\Twig\Extension\CloudinaryExtension;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * @covers \Speicher210\CloudinaryBundle\Twig\Extension\CloudinaryExtension
 */
final class CloudinaryExtensionTest extends TestCase
{
    private Environment $twig;

    protected function setUp(): void
    {
        $cloudinary = new Cloudinary(['cloud_name' => 'test']);
        $extension  = new CloudinaryExtension($cloudinary);

        $this->twig = new Environment(new FilesystemLoader());
        $this->twig->addExtension($extension);
    }

    public function testUrlFunction(): void
    {
        $template = $this->twig->createTemplate('{{ cloudinary_url(url) }}');

        self::assertSame(
            'https://res.cloudinary.com/test/image/upload/id?_a=AAFIKDQ',
            $template->render(['url' => 'id']),
        );
    }

    public function testUrlFilter(): void
    {
        $template = $this->twig->createTemplate('{{ url | cloudinary_url }}');

        self::assertSame(
            'https://res.cloudinary.com/test/image/upload/id?_a=AAFIKDQ',
            $template->render(['url' => 'id']),
        );
    }

    public function testImageTagFunction(): void
    {
        $template = $this->twig->createTemplate('{{ cloudinary_image_tag(url) }}');

        self::assertSame(
            '<img src="https://res.cloudinary.com//image/upload/id?_a=AAFIKDQ">',
            $template->render(['url' => 'id']),
        );
    }

    public function testImageTagFilter(): void
    {
        $template = $this->twig->createTemplate('{{ url | cloudinary_image_tag }}');

        self::assertSame(
            '<img src="https://res.cloudinary.com//image/upload/id?_a=AAFIKDQ">',
            $template->render(['url' => 'id']),
        );
    }

    public function testPictureTagFunction(): void
    {
        $template = $this->twig->createTemplate('{{ cloudinary_picture_tag(url) }}');

        self::assertSame(
            <<<'HTML'
            <picture>
            <img src="https://res.cloudinary.com//image/upload/id?_a=AAFIKDQ">
            </picture>
            HTML,
            $template->render(['url' => 'id']),
        );
    }

    public function testPictureTagFilter(): void
    {
        $template = $this->twig->createTemplate('{{ url | cloudinary_picture_tag }}');

        self::assertSame(
            <<<'HTML'
            <picture>
            <img src="https://res.cloudinary.com//image/upload/id?_a=AAFIKDQ">
            </picture>
            HTML,
            $template->render(['url' => 'id']),
        );
    }

    public function testVideoTagFunction(): void
    {
        $template = $this->twig->createTemplate('{{ cloudinary_video_tag(url) }}');

        self::assertSame(
            <<<'HTML'
            <video poster="https://res.cloudinary.com//video/upload/id.jpg?_a=AAFIKDQ">
            <source src="https://res.cloudinary.com//video/upload/vc_h265/id.mp4?_a=AAFIKDQ" type="video/mp4; codecs=hev1">
            <source src="https://res.cloudinary.com//video/upload/vc_vp9/id.webm?_a=AAFIKDQ" type="video/webm; codecs=vp9">
            <source src="https://res.cloudinary.com//video/upload/vc_auto/id.mp4?_a=AAFIKDQ" type="video/mp4">
            <source src="https://res.cloudinary.com//video/upload/vc_auto/id.webm?_a=AAFIKDQ" type="video/webm">
            </video>
            HTML,
            $template->render(['url' => 'id']),
        );
    }

    public function testVideoTagFilter(): void
    {
        $template = $this->twig->createTemplate('{{ url | cloudinary_video_tag }}');

        self::assertSame(
            <<<'HTML'
            <video poster="https://res.cloudinary.com//video/upload/id.jpg?_a=AAFIKDQ">
            <source src="https://res.cloudinary.com//video/upload/vc_h265/id.mp4?_a=AAFIKDQ" type="video/mp4; codecs=hev1">
            <source src="https://res.cloudinary.com//video/upload/vc_vp9/id.webm?_a=AAFIKDQ" type="video/webm; codecs=vp9">
            <source src="https://res.cloudinary.com//video/upload/vc_auto/id.mp4?_a=AAFIKDQ" type="video/mp4">
            <source src="https://res.cloudinary.com//video/upload/vc_auto/id.webm?_a=AAFIKDQ" type="video/webm">
            </video>
            HTML,
            $template->render(['url' => 'id']),
        );
    }
}
