<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony Api Starter project.
 * (c) Firstname Lastname <email@domain.tld>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('api_platform', [
        'title' => 'Symfony Api Starter',
        'show_webby' => false,
        'swagger' => [
            'api_keys' => [
                'JWT' => [
                    'name' => 'Authorization',
                    'type' => 'header',
                ],
            ],
        ],
        'formats' => [
            'jsonld' => [
                'application/ld+json',
            ],
            'json' => [
                'application/json',
            ],
        ],
        'docs_formats' => [
            'jsonld' => [
                'application/ld+json',
            ],
            'json' => [
                'application/json',
            ],
            'jsonopenapi' => [
                'application/vnd.openapi+json',
            ],
            'html' => [
                'text/html',
            ],
        ],
        'defaults' => [
            'stateless' => true,
            'cache_headers' => [
                'vary' => [
                    'Content-Type',
                    'Authorization',
                    'Origin',
                ],
            ],
            'pagination_client_items_per_page' => true,
            'pagination_items_per_page' => 25,
            'order_parameter_name' => 'sortBy',
        ],
        'collection' => [
            'pagination' => [
                'items_per_page_parameter_name' => 'itemsPerPage',
            ],
        ],
        'mapping' => [
            'paths' => [
                '%kernel.project_dir%/src/Security/Entity',
            ],
        ],
    ]);
};
