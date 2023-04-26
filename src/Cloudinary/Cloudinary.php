<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Cloudinary;

class Cloudinary extends \Cloudinary\Cloudinary
{
    public function adminApi(): Admin
    {
        return new Admin($this->configuration);
    }

    public function uploadApi(): Uploader
    {
        return new Uploader($this->configuration);
    }
}
