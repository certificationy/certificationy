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
use Certificationy\Certification\SetFactory;

/**
 * SetFactoryTest
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class SetFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QuestionLoader
     */
    protected $loader;

    /**
     * @var SetFactory
     */
    protected $factory;

    /**
     * Prepares every test with a question loader
     */
    public function setUp()
    {
        $this->loader  = new QuestionLoader(__DIR__ . '/../data/');
        $this->factory = new SetFactory($this->loader);
    }

    /**
     * Tests the creation of a Set instance with questions
     */
    public function testCreate()
    {
        $set = $this->factory->create(3);

        $this->assertInstanceOf('Certificationy\Certification\Set', $set);
        $this->assertNull($set->getAnswers(), 'Should not have any answers yet');
    }
}
