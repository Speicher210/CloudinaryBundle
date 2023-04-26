<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Cloudinary;

/**
 * Uploader wrapper class for Cloudinary Uploader.
 */
class Uploader extends \Cloudinary\Uploader
{
    public function __construct(Cloudinary $cloudinary)
    {
    }
}
