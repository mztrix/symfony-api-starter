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
    if ('dev' === $containerConfigurator->env()) {
        $containerConfigurator->extension('web_profiler', [
            'toolbar' => true,
        ]);
        $containerConfigurator->extension('framework', [
            'profiler' => [
                'collect_serializer_data' => true,
            ],
        ]);
    }
    if ('test' === $containerConfigurator->env()) {
        $containerConfigurator->extension('framework', [
            'profiler' => [
                'collect' => false,
            ],
        ]);
    }
};
