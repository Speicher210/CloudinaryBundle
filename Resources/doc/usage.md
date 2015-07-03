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

Add [`speicher210/CloudinaryBundle`](https://packagist.org/packages/speicher210/CloudinaryBundle)
to your `composer.json` file:

    composer require "speicher210/CloudinaryBundle"

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

Further documentation
---------------------

- [Cloudinary PHP library](https://github.com/cloudinary/cloudinary_php)