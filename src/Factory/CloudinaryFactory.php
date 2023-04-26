<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Factory;

use Cloudinary\Configuration\Configuration;
use Speicher210\CloudinaryBundle\Cloudinary\Cloudinary;

use function array_key_exists;
use function parse_url;

final class CloudinaryFactory
{
    private readonly Configuration $configuration;

    /**
     * @param array{url?: string, cloud_name?: string, access_identifier?: array{api_key: string, api_secret: string}, secure?: bool} $config
     */
    public function __construct(array $config)
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

        $this->configuration = Configuration::fromParams(
            [
                'cloud' => [
                    'cloud_name' => $config['cloud_name'],
                    'api_key' => $config['access_identifier']['api_key'],
                    'api_secret' => $config['access_identifier']['api_secret'],
                ],
                'url' => [
                    'secure' => $config['secure'] ?? true,
                ],
            ],
        );
    }

    public function createCloudinary(): Cloudinary
    {
        return new Cloudinary($this->configuration);
    }
}
