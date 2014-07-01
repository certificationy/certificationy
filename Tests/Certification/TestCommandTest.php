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

use Certificationy\Certification\QuestionLoader;
use Certificationy\Command\TestCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * TestCommandTest
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 * @author Cas Leentfaar <info@casleentfaar.com>
 */
class TestCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TestCommand
     */
    private $command;

    /**
     * Prepares each test by creating an Application instance to interact with
     */
    public function setUp()
    {
        $app = new Application();
        $app->add(new TestCommand());
        $this->command = $app->find('test');
    }

    /**
     * Tests whether all categories are listed through the --list (-l) option
     */
    public function testCanListCategories()
    {
        $loader = new QuestionLoader(__DIR__ . '/../data/');
        $output = $this->execute(array(
            '-l' => true,
            '-e' => 'test',
        ));
        $this->assertRegExp('/Foobar/', $output);
        $this->assertCount(count($loader->getCategories()) + 1, explode("\n", $output));
    }

    /**
     * Tests whether questions are returned by the Test command
     */
    public function testCanGetQuestions()
    {
        $helper = $this->command->getHelper('question');
        $helper->setInputStream($this->getInputStream(str_repeat("1\n", 20)));

        $output = $this->execute(array(
            '-e'       => 'test',
            '--number' => 3,
        ));
        $this->assertRegExp('/Starting a new set of 3 questions/', $output);
    }

    /**
     * Wrapper method to execute the TestCommand with the given arguments
     *
     * @param array $args Arguments to use for execution
     *
     * @return string
     */
    protected function execute(array $args)
    {
        $args          = array_merge(array('command' => $this->command->getName()), $args);
        $commandTester = new CommandTester($this->command);
        $commandTester->execute($args);
        $output = $commandTester->getDisplay();

        return $output;
    }

    /**
     * Returns a resource executed with the input from the user
     *
     * @param string $input The input to sent as user
     *
     * @return resource
     */
    protected function getInputStream($input)
    {
        $stream = fopen('php://memory', 'r+', false);
        fputs($stream, $input);
        rewind($stream);

        return $stream;
    }
}
