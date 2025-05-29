<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony Api Starter project.
 * (c) Firstname Lastname <email@domain.tld>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Security\Entity;

use ApiPlatform\Metadata as ApiMetadata;
use ApiPlatform\OpenApi\Model\Operation;
use App\Security\ApiPlatform\State\UserProcessor;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute as Serializer;
use Symfony\Component\Uid\Ulid;

/**
 * Supports user account management.
 *
 * Enables client applications to create new users, retrieve user profiles,
 * update credentials (such as passwords), and assign application roles.
 *
 * Typically used in authentication workflows and administrative user management interfaces.
 */
#[ORM\Entity]
#[ORM\Table(name: '`user`')]
#[ApiMetadata\ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
    openapi: new Operation(tags: ['Security']),
    processor: UserProcessor::class,
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME)]
    #[ORM\CustomIdGenerator(class: UlidGenerator::class)]
    #[ORM\GeneratedValue('CUSTOM')]
    #[Serializer\Groups(['user:read'])]
    public Ulid $id;

    #[ORM\Column(type: Types::STRING, length: 128, unique: true)]
    #[Serializer\Groups(['user:read', 'user:write'])]
    public string $identifier;

    /**
     * The password of the user (hashed).
     */
    #[ORM\Column(type: Types::STRING, length: 128)]
    public string $password;

    /**
     * The plain password entered by the user (for validation purposes).
     * This is used for creating or updating the password, but is not stored in the database.
     */
    #[Serializer\Groups(['user:write'])]
    public ?string $plainPassword;

    /**
     * The roles assigned to the user.
     * This is a list of roles (e.g., 'ROLE_USER', 'ROLE_ADMIN') that define the user's permissions within the system.
     */
    /** @var list<string> */
    #[ORM\Column(type: Types::JSON)]
    #[Serializer\Groups(['user:read', 'user:write'])]
    public array $roles = [];

    /**
     * Get the password used for authentication.
     * This method is required by the `PasswordAuthenticatedUserInterface`.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Get the roles assigned to the user.
     * This method is required by the `UserInterface`.
     *
     * @return list<string> A list of roles (e.g., 'ROLE_USER', 'ROLE_ADMIN').
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * Get the unique identifier of the user.
     * This method is required by the `UserInterface`.
     */
    public function getUserIdentifier(): string
    {
        return $this->identifier;
    }

    #[\Deprecated(
        message: 'The "eraseCredentials()" method is deprecated since Symfony 7.3. It will be removed in Symfony 8.0. Consider using AuthenticationTokenCreatedListener to erase credentials after authentication instead.',
        since: '7.3'
    )]
    public function eraseCredentials(): void
    {
    }
}
