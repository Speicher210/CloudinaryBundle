<?php

namespace Speicher210\CloudinaryBundle\Twig\Extension;

use Speicher210\CloudinaryBundle\Cloudinary\Cloudinary;

/**
 * Cloudinary twig extension.
 */
class CloudinaryExtension extends \Twig_Extension
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
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('cloudinary_url', [$this, 'getUrl']),
            new \Twig_SimpleFunction('cloudinary_image_tag', [$this, 'getImageTag'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('cloudinary_video_tag', [$this, 'getVideoTag'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('cloudinary_url', [$this, 'getUrl']),
            new \Twig_SimpleFilter('cloudinary_image_tag', [$this, 'getImageTag'], ['is_safe' => ['html']]),
            new \Twig_SimpleFilter('cloudinary_video_tag', [$this, 'getVideoTag'], ['is_safe' => ['html']]),
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
        $options = array_merge($this->cloudinary::config(), $options);

        return $this->cloudinary::cloudinary_url($id, $options);
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
        $options = array_merge($this->cloudinary::config(), $options);

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
        $options = array_merge($this->cloudinary::config(), $options);

        return cl_video_tag($id, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cloudinary';
    }
}
