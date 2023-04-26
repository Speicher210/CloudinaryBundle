<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Twig\Extension;

use Cloudinary\Configuration\Configuration;
use Cloudinary\Tag\ImageTag;
use Cloudinary\Tag\PictureTag;
use Cloudinary\Tag\VideoTag;
use Cloudinary\Transformation\ImageTransformation;
use Speicher210\CloudinaryBundle\Cloudinary\Cloudinary;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class CloudinaryExtension extends AbstractExtension
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
            new TwigFunction('cloudinary_url', $this->getUrl(...)),
            new TwigFunction('cloudinary_image_tag', $this->getImageTag(...), ['is_safe' => ['html']]),
            new TwigFunction('cloudinary_picture_tag', $this->getPictureTag(...), ['is_safe' => ['html']]),
            new TwigFunction('cloudinary_video_tag', $this->getVideoTag(...), ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('cloudinary_url', $this->getUrl(...)),
            new TwigFilter('cloudinary_image_tag', $this->getImageTag(...), ['is_safe' => ['html']]),
            new TwigFilter('cloudinary_picture_tag', $this->getPictureTag(...), ['is_safe' => ['html']]),
            new TwigFilter('cloudinary_video_tag', $this->getVideoTag(...), ['is_safe' => ['html']]),
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
        return (string) $this->cloudinary
            ->image($id)
            ->toUrl(ImageTransformation::fromParams($options));
    }

    /**
     * Get the cloudinary image tag.
     *
     * @param string       $id      Public ID.
     * @param array<mixed> $options options for the image.
     */
    public function getImageTag(string $id, array $options = []): string
    {
        $imageTag = new ImageTag($id, Configuration::fromParams($options));

        return $imageTag->toTag();
    }

    /**
     * Get the cloudinary picture tag.
     *
     * @param string       $id      Public ID.
     * @param array<mixed> $options Options for the image.
     */
    public function getPictureTag(string $id, array $options = []): string
    {
        $videoTag = new PictureTag($id, [], Configuration::fromParams($options));

        return $videoTag->toTag();
    }

    /**
     * Get the cloudinary video tag.
     *
     * @param string       $id      Public ID.
     * @param array<mixed> $options Options for the image.
     */
    public function getVideoTag(string $id, array $options = []): string
    {
        $videoTag = new VideoTag($id, null, Configuration::fromParams($options));

        return $videoTag->toTag();
    }
}
