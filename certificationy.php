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

use Certificationy\Command\StartCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new StartCommand());
$application->run();
