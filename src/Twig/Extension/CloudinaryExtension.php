<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Twig\Extension;

use Speicher210\CloudinaryBundle\Cloudinary\Cloudinary;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

use function cl_image_tag;
use function cl_video_tag;

/**
 * Cloudinary twig extension.
 */
class CloudinaryExtension extends AbstractExtension
{
    private Cloudinary $cloudinary;

    /**
     * @param Cloudinary $cloudinary The cloudinary library.
     */
    public function __construct(Cloudinary $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('cloudinary_url', [$this, 'getUrl']),
            new TwigFunction('cloudinary_image_tag', [$this, 'getImageTag'], ['is_safe' => ['html']]),
            new TwigFunction('cloudinary_video_tag', [$this, 'getVideoTag'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('cloudinary_url', [$this, 'getUrl']),
            new TwigFilter('cloudinary_image_tag', [$this, 'getImageTag'], ['is_safe' => ['html']]),
            new TwigFilter('cloudinary_video_tag', [$this, 'getVideoTag'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Get the cloudinary URL.
     *
     * @param string       $id      Public ID.
     * @param array<mixed> $options options for the image.
     */
    public function getUrl(string $id, array $options = []): string
    {
        $cloudinary = $this->cloudinary;

        return $cloudinary::cloudinary_url($id, $options);
    }

    /**
     * Get the cloudinary image tag.
     *
     * @param string       $id      Public ID.
     * @param array<mixed> $options options for the image.
     */
    public function getImageTag(string $id, array $options = []): string
    {
        return cl_image_tag($id, $options);
    }

    /**
     * Get the cloudinary video tag.
     *
     * @param string       $id      Public ID.
     * @param array<mixed> $options Options for the image.
     */
    public function getVideoTag(string $id, array $options = []): string
    {
        return cl_video_tag($id, $options);
    }
}
