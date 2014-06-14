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

use Certificationy\Command\StartCommand;
use Certificationy\Application\Certificationy as Application;

$application = new Application();
$application->run();
