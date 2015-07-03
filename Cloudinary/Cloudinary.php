<?php

namespace Speicher210\CloudinaryBundle\Cloudinary;

/**
 * Cloudinary wrapper class for Cloudinary.
 */
class Cloudinary extends \Cloudinary
{
    /**
     * Constructor.
     *
     * @param array $config The cloudinary configurations.
     */
    public function __construct(array $config)
    {
        static::config($config);
    }
}
