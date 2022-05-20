<?php

namespace Speicher210\CloudinaryBundle\Twig\Extension;

use Speicher210\CloudinaryBundle\Cloudinary\Cloudinary;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Cloudinary twig extension.
 */
class CloudinaryExtension extends AbstractExtension
{
    /**
     * @var Cloudinary
     */
    private $cloudinary;

    /**
     * @param Cloudinary $cloudinary The cloudinary library.
     */
    public function __construct(Cloudinary $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }

    /**
     * {@inheritdoc}
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('cloudinary_url', [$this, 'getUrl']),
            new TwigFunction('cloudinary_image_tag', [$this, 'getImageTag'], ['is_safe' => ['html']]),
            new TwigFunction('cloudinary_video_tag', [$this, 'getVideoTag'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     * @return array
     */
    public function getFilters()
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
     * @param string $id Public ID.
     * @param array $options options for the image.
     *
     * @return string
     */
    public function getUrl($id, $options = [])
    {
        $cloudinary = $this->cloudinary;
        $options = array_merge($cloudinary::config(), $options);

        return $cloudinary::cloudinary_url($id, $options);
    }

    /**
     * Get the cloudinary image tag.
     *
     * @param string $id Public ID.
     * @param array $options options for the image.
     *
     * @return string
     */
    public function getImageTag($id, $options = [])
    {
        $cloudinary = $this->cloudinary;
        $options = array_merge($cloudinary::config(), $options);

        return cl_image_tag($id, $options);
    }

    /**
     * Get the cloudinary video tag.
     *
     * @param string $id Public ID.
     * @param array $options Options for the image.
     *
     * @return string
     */
    public function getVideoTag($id, $options = [])
    {
        $cloudinary = $this->cloudinary;
        $options = array_merge($cloudinary::config(), $options);

        return cl_video_tag($id, $options);
    }
}
