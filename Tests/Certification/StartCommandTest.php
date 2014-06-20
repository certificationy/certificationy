<?php
/*
 * This file is part of the Eko\FeedBundle Symfony bundle.
 *
 * (c) Vincent Composieux <vincent.composieux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Certificationy\Tests;

use Certificationy\Certification\Loader;
use Certificationy\Command\StartCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * StartCommandTest
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class StartCommandTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var StartCommand
     */
    private $command;
    
    public function setUp()
    {
        $app = new Application();
        $app->add(new StartCommand());
        $this->command = $app->find('start');
    }
    
    public function testCanListCategories()
    {
        $commandTester = new CommandTester($this->command);
        $commandTester->execute(array(
            'command' => $this->command->getName(),
            '-l' => true
        ));
                
        $output = $commandTester->getDisplay();
        $this->assertRegExp('/Twig/', $output);
        $this->assertCount(count(Loader::getCategories()) + 1, explode("\n", $output));
    }
    
    public function testCanGetQuestions()
    {
        $helper = $this->command->getHelper('question');
        $helper->setInputStream($this->getInputStream(str_repeat("0\n", 20)));
        
        $commandTester = new CommandTester($this->command);
        $commandTester->execute(array(
            'command' => $this->command->getName(),
        ));
                
        $output = $commandTester->getDisplay();
        $this->assertRegExp('/Twig/', $output);
        $this->assertRegExp('/Starting a new set of 20 questions/', $commandTester->getDisplay());
    }
    
    protected function getInputStream($input)
    {
        $stream = fopen('php://memory', 'r+', false);
        fputs($stream, $input);
        rewind($stream);
        return $stream;
    }
    
} 