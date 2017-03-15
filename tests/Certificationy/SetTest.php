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

namespace Tests\Certificationy;

use Certificationy\Collections\Answers;
use Certificationy\Collections\Questions;
use Certificationy\Answer;
use Certificationy\Set;
use Certificationy\Question;

class SetTest extends \PHPUnit\Framework\TestCase
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
        return $this->set = new Set(new Questions([
            new Question('my first question', 'my first category', new Answers([
                new Answer('my first answer', true),
                new Answer('my second answer', false)
            ])),
            new Question('my second question', 'my second category', new Answers([
                new Answer('my first answer', false),
                new Answer('my second answer', true)
            ]))
        ]));
    }

    /**
     * Tests getters and setters
     */
    public function testGettersSetters()
    {
        $this->assertSame(2, $this->set->getQuestions()->count());

        foreach ($this->set->getQuestions() as $question) {
            $this->assertInstanceOf('Certificationy\Question', $question);
        }

        $this->assertInstanceOf('Certificationy\Question', $this->set->getQuestion(0));

        $this->assertEquals('my first question', $this->set->getQuestion(0)->getQuestion());
        $this->assertEquals('my second question', $this->set->getQuestion(1)->getQuestion());
    }

    /**
     * Tests answers methods
     */
    public function testAnswers()
    {
        $this->set->setAnswers(0, ['my first answer']);
        $this->set->setAnswers(1, ['my second answer']);

        $this->assertCount(2, $this->set->getAnswers()->all());

        $this->assertEquals('my first answer', $this->set->getAnswer(0)->getValue());
        $this->assertEquals('my second answer', $this->set->getAnswer(1)->getValue());
    }
}