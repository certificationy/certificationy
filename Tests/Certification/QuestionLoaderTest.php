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

/**
 * QuestionLoaderTest
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 * @author Cas Leentfaar <info@casleentfaar.com>
 */
class QuestionLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QuestionLoader
     */
    protected $loader;

    /**
     * Prepares every test with a question loader
     */
    public function setUp()
    {
        $this->loader = new QuestionLoader(__DIR__ . '/../data/');
    }

    /**
     * Tests the getter methods of the loader
     */
    public function testGetters()
    {
        $this->assertInternalType('array', $this->loader->getData());
        $this->assertInternalType('array', $this->loader->getCategories());
        $this->assertInstanceOf('Symfony\Component\OptionsResolver\OptionsResolver', $this->loader->getQuestionResolver());
        $this->assertInstanceOf('Symfony\Component\OptionsResolver\OptionsResolver', $this->loader->getCategoryResolver());
    }
}
