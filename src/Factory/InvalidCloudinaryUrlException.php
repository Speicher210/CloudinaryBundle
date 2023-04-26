<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Factory;

use InvalidArgumentException;

class InvalidCloudinaryUrlException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Cloudinary URL must be in the form: cloudinary://api_key:api_secret@cloud_name');
    }
}
