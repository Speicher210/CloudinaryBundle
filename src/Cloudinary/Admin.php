<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Cloudinary;

use Cloudinary\Api\Admin\AdminApi;
use Cloudinary\Configuration\Configuration;

class Admin extends AdminApi
{
    public readonly Configuration $configuration;

    public function __construct(Configuration $configuration)
    {
        parent::__construct($configuration);

        $this->configuration = $configuration;
    }
}
