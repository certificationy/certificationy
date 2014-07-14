<?php
/*
 * This file is part of the Certificationy application.
 *
 * (c) Vincent Composieux <vincent.composieux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Certificationy\Tests;

use Certificationy\Certification\Answer;
use Certificationy\Certification\Set;
use Certificationy\Certification\Question;

/**
 * SetTest
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class SetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Set
     */
    protected $set;

    /**
     * Sets up a set of questions
     *
     * @return Set
     */
    public function setUp()
    {
        return $this->set = new Set(array(
            new Question('my first question', 'my first category', array(
                new Answer('my first answer', true),
                new Answer('my second answer', false)
            )),
            new Question('my second question', 'my second category', array(
                new Answer('my first answer', false),
                new Answer('my second answer', true)
            ))
        ));
    }

    /**
     * Tests getters and setters
     */
    public function testGettersSetters()
    {
        $this->assertCount(2, $this->set->getQuestions());

        foreach ($this->set->getQuestions() as $question) {
            $this->assertInstanceOf('Certificationy\Certification\Question', $question);
        }

        $this->assertInstanceOf('Certificationy\Certification\Question', $this->set->getQuestion(0));

        $this->assertEquals('my first question', $this->set->getQuestion(0)->getQuestion());
        $this->assertEquals('my second question', $this->set->getQuestion(1)->getQuestion());
    }

    /**
     * Tests answers methods
     */
    public function testAnswers()
    {
        $this->set->setAnswer(0, 'my first answer');
        $this->set->setAnswer(1, 'my second answer');

        $this->assertCount(2, $this->set->getAnswers());

        $this->assertEquals('my first answer', $this->set->getAnswer(0));
        $this->assertEquals('my second answer', $this->set->getAnswer(1));
    }
}