<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony Api Starter project.
 * (c) Firstname Lastname <email@domain.tld>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Fixtures\Factory;

use App\Users\Model\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @internal
 *
 * @extends PersistentObjectFactory<User>
 */
class UserFactory extends PersistentObjectFactory
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
        parent::__construct();
    }

    #[\Override]
    public static function class(): string
    {
        return User::class;
    }

    #[\Override]
    protected function defaults(): array
    {
        return [
            'identifier' => self::faker()->text(128),
            'plainPassword' => '$ecr$tPa$$word',
            'roles' => [],
        ];
    }

    #[\Override]
    protected function initialize(): static
    {
        return $this->afterInstantiate(function (User $user): void {
            $user->password = $this->userPasswordHasher->hashPassword($user, $user->plainPassword);
        });
    }
}
