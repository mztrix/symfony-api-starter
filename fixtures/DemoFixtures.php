<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony Api Starter project.
 * (c) Firstname Lastname <email@domain.tld>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Fixtures;

use App\Fixtures\Story\DemoStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class DemoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        DemoStory::load();
    }
}
