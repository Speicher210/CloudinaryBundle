<?php

namespace Speicher210\CloudinaryBundle\Cloudinary;

/**
 * API wrapper class for Cloudinary Api.
 */
class Api extends \Cloudinary\Api
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
