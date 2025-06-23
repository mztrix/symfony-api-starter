<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony Api Starter project.
 * (c) Firstname Lastname <email@domain.tld>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Fixtures\Story;

use App\Fixtures\Factory\UserFactory;
use Zenstruck\Foundry\Attribute\AsFixture;
use Zenstruck\Foundry\Story;

#[AsFixture(name: 'demo')]
final class DemoStory extends Story
{
    public function build(): void
    {
        // create a user
        UserFactory::createOne(['identifier' => 'demo@demo.fr', 'plainPassword' => 'demo1234%']);
    }
}
