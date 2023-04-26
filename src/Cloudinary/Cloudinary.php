<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Cloudinary;

/**
 * Cloudinary wrapper class for Cloudinary.
 */
class Cloudinary extends \Cloudinary
{
    /**
     * @param array<mixed> $config The cloudinary configurations.
     */
    public function __construct(array $config)
    {
        static::config($config);
    }
}
