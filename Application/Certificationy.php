<?php

/*
 * This file is part of the Certificationy application.
 *
 * (c) Vincent Composieux <vincent.composieux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Certificationy\Application;

use Certificationy\Command\CategoryCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Certificationy\Command\StartCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class Certificationy
 *
 * @author Mickaël Andrieu <andrieu.travail@gmail.com>
 */
class Certificationy extends Application
{
    /**
     * {@inheritdoc}
     */
    /*protected function getCommandName(InputInterface $input)
    {
        return 'start';
    }*/

    /**
     * {@inheritdoc}
     */
    /*protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();
        $defaultCommands[] = new StartCommand();
        $defaultCommands[] = new CategoryCommand();

        return $defaultCommands;
    }*/

    /**
     * {@inheritdoc}
     */
    /*public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments();

        return $inputDefinition;
    }*/
    
    /**
     * Gets the default input definition.
     *
     * @return InputDefinition An InputDefinition instance
     */
    protected function getDefaultInputDefinition()
    {
        return new InputDefinition(array(
            new InputArgument('command', InputArgument::REQUIRED, 'The command to execute'),

            new InputOption('--help',    '-h', InputOption::VALUE_NONE, 'Display this help message.'),
            new InputOption('--version', '-V', InputOption::VALUE_NONE, 'Display this application version.'),
            new InputOption('--ansi',    null, InputOption::VALUE_NONE, 'Force ANSI output.'),
            new InputOption('--no-ansi', null, InputOption::VALUE_NONE, 'Disable ANSI output.'),
        ));
    }
}
