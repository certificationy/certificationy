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

/**
 * LoaderTest
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class LoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests loader
     */
    public function testInitialization()
    {
        $set = Loader::init(5, array());

        $this->assertInstanceOf('Certificationy\Certification\Set', $set, 'Should return an instance of set');

        $this->assertCount(5, $set->getQuestions(), 'Should return 5 questions');

        $this->assertNull($set->getAnswers());
    }
    
    public function testCanGetCategoryList()
    {
        $this->assertTrue(is_array(Loader::getCategories()));
    }
    
}