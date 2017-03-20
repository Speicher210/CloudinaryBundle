<?php

namespace Speicher210\CloudinaryBundle\Factory;

class InvalidCloudinaryUrlException extends \InvalidArgumentException
{
    /**
     * @var string
     */
    protected $message = 'Cloudinary URL must be in the form: cloudinary://api_key:api_secret@cloud_name';
}
