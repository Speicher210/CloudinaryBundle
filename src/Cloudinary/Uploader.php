<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Cloudinary;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

class Uploader extends UploadApi
{
    public readonly Configuration $configuration;

    public function __construct(Configuration $configuration)
    {
        parent::__construct($configuration);

        $this->configuration = $configuration;
    }
}
