#!/usr/bin/env php
<?php

/*
 * This file is part of the Certificationy application.
 *
 * (c) Vincent Composieux <vincent.composieux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__.'/vendor/autoload.php';

use Certificationy\Application\Certificationy as Application;
use Certificationy\Command\CategoryCommand;
use Certificationy\Command\StartCommand;

$application = new Application();
$application->add(new StartCommand());
$application->add(new CategoryCommand());
$application->run();
