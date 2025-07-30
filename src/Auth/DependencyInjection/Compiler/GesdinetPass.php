<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony Api Starter project.
 * (c) Firstname Lastname <email@domain.tld>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Auth\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class GesdinetPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $this->addOpenApiFactory($container);
    }

    private function addOpenApiFactory(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('gesdinet_jwt_refresh.api_platform.openapi.factory') || !$container->hasParameter('security.firewalls')) {
            return;
        }

        $checkPath = null;
        $firewalls = $container->getParameter('security.firewalls');
        foreach ($firewalls as $firewallName) {
            if ($container->hasDefinition('security.authenticator.refresh_jwt.' . $firewallName)) {
                $firewallOptions = $container->getDefinition('security.authenticator.refresh_jwt.' . $firewallName)->getArgument(6);
                $checkPath = $firewallOptions['check_path'];
                break;
            }
        }

        $openApiFactoryDefinition = $container->getDefinition('gesdinet_jwt_refresh.api_platform.openapi.factory');

        $checkPathArg = $openApiFactoryDefinition->getArgument(0);

        if (!$checkPath && !$checkPathArg) {
            $container->removeDefinition('gesdinet_jwt_refresh.api_platform.openapi.factory');

            return;
        }

        if (!$checkPathArg) {
            $openApiFactoryDefinition->replaceArgument(1, $checkPath);
        }
    }
}
