<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony Api Starter project.
 * (c) Firstname Lastname <email@domain.tld>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Kernel;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

return fn (array $context): Kernel => new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
