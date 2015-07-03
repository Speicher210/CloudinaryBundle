<?php

namespace Speicher210\CloudinaryBundle\Tests\Twig\Extension;

use Speicher210\CloudinaryBundle\Cloudinary\Cloudinary;
use Speicher210\CloudinaryBundle\Twig\Extension\CloudinaryExtension;

class CloudinaryExtensionTest extends \PHPUnit_Framework_TestCase
{

    public function testGetUrl()
    {
        $cloudinary = new Cloudinary(array('cloud_name' => 'test'));
        $ext = new CloudinaryExtension($cloudinary);

        $this->assertEquals(
            $cloudinary->cloudinary_url('test'),
            $ext->getUrl('test')
        );
    }
}
