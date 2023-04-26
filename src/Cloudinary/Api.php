<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Cloudinary;

/**
 * API wrapper class for Cloudinary Api.
 */
class Api extends \Cloudinary\Api
{
    public function __construct(Cloudinary $cloudinary)
    {
    }
}
