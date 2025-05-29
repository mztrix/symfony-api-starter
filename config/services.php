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
    $containerConfigurator->import(__DIR__ . '/parameters.php');

    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    $services->load('App\\', __DIR__ . '/../src/')
        ->exclude([
            __DIR__ . '/../src/DependencyInjection',
            __DIR__ . '/../src/Entity',
            __DIR__ . '/../src/Kernel.php',
            __DIR__ . '/../src/Security/DependencyInjection',
            __DIR__ . '/../src/Security/Entity',
        ])
    ;

    if (in_array($containerConfigurator->env(), ['dev', 'test'], true)) {
        $services
            ->load('App\Fixtures\\', __DIR__ . '/../fixtures/')
            ->autowire()
            ->autoconfigure()
        ;
    }
};
