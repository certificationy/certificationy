<?php

/*
 * This file is part of the Certificationy library.
 *
 * (c) Vincent Composieux <vincent.composieux@gmail.com>
 * (c) Mickaël Andrieu <andrieu.travail@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Certificationy\Loaders;

use Certificationy\Loaders\PhpArrayLoader;
use Certificationy\Set;

class PhpArrayLoaderTest extends \PHPUnit\Framework\TestCase
{
    private $configFile;
    private $arrayLoader;

    public function setUp()
    {
        $this->configFile = __DIR__
            . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . 'assets'
            . DIRECTORY_SEPARATOR . 'test-php-pack'
        ;
        $arrayQuestions = $this->loadQuestions();

        $this->arrayLoader = new PhpArrayLoader($arrayQuestions);
    }

    public function testInitialization()
    {
        $set = Set::create($this->arrayLoader->load(5, []));

        $this->assertInstanceOf('Certificationy\Set', $set, 'Should return an instance of set');

        $this->assertSame(5, $set->getQuestions()->count(), 'Should return 5 questions');

        $this->assertSame(0, $set->getAnswers()->count());
    }

    public function testCanGetCategoryList()
    {
        $this->assertTrue(is_array($this->arrayLoader->categories()));
        $this->assertCount(2, $this->arrayLoader->categories());
    }

    public function testCategoriesAreFiltered()
    {
        $set = Set::create($this->arrayLoader->load(5, ['A']));

        $this->assertInstanceOf('Certificationy\Set', $set, 'Should return an instance of set');
        $this->assertSame(3, $set->getQuestions()->count(), 'Should return only 3 questions from A category');
        $this->assertSame(0, $set->getAnswers()->count());

        foreach ($set->getQuestions()->all() as $question) {
            $this->assertSame($question->getCategory(), 'A', 'Should return only the filtered category');
        }
    }

    public function tearDown()
    {
        $this->arrayLoader = null;
    }

    private function loadQuestions() : array
    {
        $questionsA = include($this->configFile.'/a.php');
        $questionsB = include($this->configFile.'/b.php');

        return array_merge($questionsA, $questionsB);
    }
}
