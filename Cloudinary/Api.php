<?php

namespace Speicher210\CloudinaryBundle\Cloudinary;

/**
 * API wrapper class for Cloudinary Api.
 */
class Api extends \Cloudinary\Api
{
    /**
     * @param Cloudinary $cloudinary
     */
    public function __construct(Cloudinary $cloudinary)
    {
    }
}
