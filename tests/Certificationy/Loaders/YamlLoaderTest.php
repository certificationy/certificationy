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

use Certificationy\Loaders\YamlLoader;
use Certificationy\Set;

class YamlLoaderTest extends \PHPUnit\Framework\TestCase
{
    private $configFile;
    private $yamlLoader;

    public function setUp()
    {
        $this->configFile = __DIR__
            . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . 'assets'
            . DIRECTORY_SEPARATOR . 'test-yaml-pack'
        ;

        $this->yamlLoader = new YamlLoader([$this->configFile]);
    }

    /**
     * Tests loader
     */
    public function testInitialization()
    {
        $set = Set::create($this->yamlLoader->load(5, []));

        $this->assertInstanceOf('Certificationy\Set', $set, 'Should return an instance of set');

        $this->assertSame(5, $set->getQuestions()->count(), 'Should return 5 questions');

        $this->assertSame(0, $set->getAnswers()->count());
    }

    public function testCanGetCategoryList()
    {
        $this->assertTrue(is_array($this->yamlLoader->categories()));
        $this->assertCount(2, $this->yamlLoader->categories());
    }

    /**
     * The total of questions is 6 in fixtures.
     */
    public function testAll()
    {
        $this->assertCount(6, $this->yamlLoader->all());
    }

    public function tearDown()
    {
        $this->path = null;
    }
}
