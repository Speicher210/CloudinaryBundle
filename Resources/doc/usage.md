Speicher210 CloudinaryBundle
==============================

Overview
--------

Simple bundle for Cloudinary PHP SDK library.

Getting started
--------

This bundle requires Symfony 2.5+

Installation
------------

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

Configuration
-------------

Configure the connection to cloudinary in your `config.yml` :

``` yaml
speicher210_cloudinary:
    cloud_name: my-cloud
    access_identifier:
        api_key: my-key
        api_secret: my-secret
```

Usage
---------------------

The following services will be available:

``` php
$this->get('speicher210_cloudinary.cloudinary'); // Extension of Cloudinary from cloudinary package.

$this->get('speicher210_cloudinary.api'); // Extension of Cloudinary\Api from cloudinary package.

$this->get('speicher210_cloudinary.uploader'); // Extension of Cloudinary\Uploader from cloudinary package.
```

Usage in twig
---------------------

You can pass the same options to the twig filter:

``` twig
{{ cloudinary-image-id | cloudinary_url({'width': 50, 'height': 50, 'crop': 'fill'}) }}
```

Further documentation
---------------------

- [Cloudinary PHP library](https://github.com/cloudinary/cloudinary_php)
