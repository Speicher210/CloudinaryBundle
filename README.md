# Speicher210 CloudinaryBundle

[![Latest Version](https://img.shields.io/github/tag/Speicher210/CloudinaryBundle.svg?style=flat-square)](https://github.com/Speicher210/CloudinaryBundle/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/Speicher210/CloudinaryBundle/master.svg?style=flat-square)](https://travis-ci.org/Speicher210/CloudinaryBundle)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/Speicher210/CloudinaryBundle.svg?style=flat-square)](https://scrutinizer-ci.com/g/Speicher210/CloudinaryBundle/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/Speicher210/CloudinaryBundle.svg?style=flat-square)](https://scrutinizer-ci.com/g/Speicher210/CloudinaryBundle)

## Install

Add [`speicher210/cloudinary-bundle`](https://packagist.org/packages/speicher210/CloudinaryBundle) to your `composer.json` file:

    composer require "speicher210/cloudinary-bundle"

Register the bundle in `app/AppKernel.php`:

``` php
public function registerBundles()
{
    return array(
        // ...
        new Speicher210\CloudinaryBundle\Speicher210CloudinaryBundle(),
        // ...
    );
}
```

## Usage

Configure the connection to cloudinary in your `config.yml` :

``` yaml
speicher210_cloudinary:
    url: cloudinary://my-key:my-secret@my-cloud
    # The next configuration variables should be defined if they are not present in the URL
    # The URL will take precedence
    cloud_name: my-cloud
    access_identifier:
        api_key: my-key
        api_secret: my-secret
```

The following services will be available:

``` php
$this->get('speicher210_cloudinary.cloudinary'); // Extension of Cloudinary from cloudinary package.

$this->get('speicher210_cloudinary.api'); // Extension of Cloudinary\Api from cloudinary package.

$this->get('speicher210_cloudinary.uploader'); // Extension of Cloudinary\Uploader from cloudinary package.
```

You can pass the same options to the twig filter or function:

``` twig
{{ cloudinary-public-id | cloudinary_url({'width': 50, 'height': 50, 'crop': 'fill'}) }}
{{ cloudinary_url('cloudinary-public-id', {'width': 50, 'height': 50, 'crop': 'fill'}) }}
{{ cloudinary_image_tag('cloudinary-public-id', {'height' : 150}) }}
{{ cloudinary_video_tag('cloudinary-public-id', {'height' : 150}) }}
```

For further documentation see [Cloudinary PHP library](https://github.com/cloudinary/cloudinary_php)

## Contributings

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email instead of using the issue tracker.

## Credits

- [Dragos Protung](https://github.com/dragosprotung)
- [All contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.


[link-contributors]: ../../contributors
