<?php

namespace Speicher210\CloudinaryBundle\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Speicher210\CloudinaryBundle\Cloudinary\Cloudinary;
use Speicher210\CloudinaryBundle\Twig\Extension\CloudinaryExtension;

class CloudinaryExtensionTest extends TestCase
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var CloudinaryExtension
     */
    private $extension;

    /**
     * @var Cloudinary
     */
    private $cloudinary;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->cloudinary = new Cloudinary(['cloud_name' => 'test']);
        $this->extension = new CloudinaryExtension($this->cloudinary);

        $this->twig = new \Twig_Environment(new \Twig_Loader_Filesystem());
        $this->twig->addExtension($this->extension);
    }

    public function testUrlFunction()
    {
        $template = $this->twig->createTemplate('{{ cloudinary_url(url) }}');

        self::assertSame(
            'http://res.cloudinary.com/test/image/upload/id',
            $template->render(['url' => 'id'])
        );
    }

    public function testUrlFilter()
    {
        $template = $this->twig->createTemplate('{{ url | cloudinary_url }}');

        self::assertSame(
            'http://res.cloudinary.com/test/image/upload/id',
            $template->render(['url' => 'id'])
        );
    }

    public function testImageTagFunction()
    {
        $template = $this->twig->createTemplate('{{ cloudinary_image_tag(url) }}');

        self::assertSame(
            '<img src=\'http://res.cloudinary.com/test/image/upload/id\' />',
            $template->render(['url' => 'id'])
        );
    }

    public function testImageTagFilter()
    {
        $template = $this->twig->createTemplate('{{ url | cloudinary_image_tag }}');

        self::assertSame(
            '<img src=\'http://res.cloudinary.com/test/image/upload/id\' />',
            $template->render(['url' => 'id'])
        );
    }

    public function testVideoTagFunction()
    {
        $template = $this->twig->createTemplate('{{ cloudinary_video_tag(url) }}');

        self::assertSame(
            '<video poster=\'http://res.cloudinary.com/test/video/upload/id.jpg\'><source src=\'http://res.cloudinary.com/test/video/upload/id.webm\' type=\'video/webm\'><source src=\'http://res.cloudinary.com/test/video/upload/id.mp4\' type=\'video/mp4\'><source src=\'http://res.cloudinary.com/test/video/upload/id.ogv\' type=\'video/ogg\'></video>',
            $template->render(['url' => 'id'])
        );
    }

    public function testVideoTagFilter()
    {
        $template = $this->twig->createTemplate('{{ url | cloudinary_video_tag }}');

        self::assertSame(
            '<video poster=\'http://res.cloudinary.com/test/video/upload/id.jpg\'><source src=\'http://res.cloudinary.com/test/video/upload/id.webm\' type=\'video/webm\'><source src=\'http://res.cloudinary.com/test/video/upload/id.mp4\' type=\'video/mp4\'><source src=\'http://res.cloudinary.com/test/video/upload/id.ogv\' type=\'video/ogg\'></video>',
            $template->render(['url' => 'id'])
        );
    }
}
