<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Factory;

use Speicher210\CloudinaryBundle\Cloudinary\Cloudinary;

use function array_key_exists;
use function array_merge;
use function parse_url;

class CloudinaryFactory
{
    /**
     * @param array<mixed> $config
     */
    public static function createCloudinary(array $config = []): Cloudinary
    {
        if (array_key_exists('url', $config)) {
            $url = parse_url($config['url']);

            if ($url === false || ! array_key_exists('scheme', $url)) {
                throw new InvalidCloudinaryUrlException();
            }

            if (array_key_exists('host', $url)) {
                $config['cloud_name'] = $url['host'];
            }

            if (array_key_exists('user', $url)) {
                $config['access_identifier']['api_key'] = $url['user'];
            }

            if (array_key_exists('pass', $url)) {
                $config['access_identifier']['api_secret'] = $url['pass'];
            }
        }

        if (! isset($config['cloud_name'], $config['access_identifier']['api_key'], $config['access_identifier']['api_secret'])) {
            throw new InvalidCloudinaryUrlException();
        }

        return new Cloudinary(
            array_merge(
                $config['options'],
                [
                    'cloud_name' => $config['cloud_name'],
                    'api_key' => $config['access_identifier']['api_key'],
                    'api_secret' => $config['access_identifier']['api_secret'],
                ],
            ),
        );
    }
}
