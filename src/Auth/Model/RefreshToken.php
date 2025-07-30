<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony Api Starter project.
 * (c) Firstname Lastname <email@domain.tld>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Auth\Model;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshTokenRepository;
use Gesdinet\JWTRefreshTokenBundle\Model\AbstractRefreshToken;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Bridge\Doctrine\Types\UlidType;

#[ORM\Entity(repositoryClass: RefreshTokenRepository::class)]
class RefreshToken extends AbstractRefreshToken
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME)]
    #[ORM\CustomIdGenerator(class: UlidGenerator::class)]
    #[ORM\GeneratedValue('CUSTOM')]
    public $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    public $refreshToken;

    #[ORM\Column(name: 'identifier', type: Types::STRING, length: 128)]
    public $username;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public $valid;
}
