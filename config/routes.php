<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony Api Starter project.
 * (c) Firstname Lastname <email@domain.tld>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->add('authenticate', '/auth/login')
        ->methods([
            'POST',
        ])
    ;

    $routingConfigurator->add('auth_refresh_tokens', '/auth/refresh_tokens')
        ->methods([
            'POST',
        ])
    ;
};
