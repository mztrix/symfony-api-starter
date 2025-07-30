<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony Api Starter project.
 * (c) Firstname Lastname <email@domain.tld>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Auth\ApiPlatform\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\MediaType;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\RequestBody;
use ApiPlatform\OpenApi\OpenApi;
use App\ApiPlatform\OpenApi\OpenApiFactoryTrait;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\HttpFoundation\Response;

#[AsDecorator('api_platform.openapi.factory')]
#[AsAlias('gesdinet_jwt_refresh.api_platform.openapi.factory', public: false)]
final readonly class GesdinetOpenApiFactory implements OpenApiFactoryInterface
{
    use OpenApiFactoryTrait;

    public function __construct(
        private OpenApiFactoryInterface $decorated,
        private ?string $refreshTokenPath = null
    ) {
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);

        $openApi->getPaths()->addPath('/auth/refresh_tokens', new PathItem()->withPost(
            new Operation()
                ->withOperationId('api_auth_refresh_tokens_post')
                ->withTags(['Auth'])
                ->withResponses([
                    Response::HTTP_OK => [
                        'description' => 'User token refreshed.',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'token' => [
                                            'readOnly' => true,
                                            'type' => 'string',
                                            'nullable' => false,
                                        ],
                                        'refresh_token' => [
                                            'readOnly' => true,
                                            'type' => 'string',
                                            'nullable' => false,
                                        ],
                                    ],
                                    'required' => ['token', 'refresh_token'],
                                ],
                            ],
                        ],
                    ],
                ])
                ->withSummary('Refresh a user token.')
                ->withDescription('Refresh a user token.')
                ->withRequestBody(
                    new RequestBody()
                        ->withDescription('The refresh_token to refresh token')
                        ->withContent(new \ArrayObject([
                            'application/json' => new MediaType(new \ArrayObject(new \ArrayObject([
                                'type' => 'object',
                                'properties' => $properties = $this->getJsonSchemaFromPathParts(explode('.', 'refresh_token')),
                                'required' => array_keys($properties),
                            ]))),
                        ]))
                        ->withRequired(true)
                )
        ));

        return $openApi;
    }
}
