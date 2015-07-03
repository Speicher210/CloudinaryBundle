<?php

namespace Speicher210\CloudinaryBundle\Cloudinary;

/**
 * Uploader wrapper class for Cloudinary Uploader.
 */
class Uploader extends \Cloudinary\Uploader
{

    /**
     * @var Cloudinary
     */
    private $cloudinary;

    /**
     * Constructor.
     *
     * @param Cloudinary $cloudinary The cloudinary instance already configured.
     */
    public function __construct(Cloudinary $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }
}