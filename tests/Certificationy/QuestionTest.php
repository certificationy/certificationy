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
use Certificationy\Question;

class QuestionTest extends TestCase
{
    /**
     * @var Question
     */
    protected $question;

    /**
     * @var array
     */
    protected $answers;

    /**
     * Sets up a question
     */
    public function setUp()
    {
        $this->answers = self::answersFromArray([
            ['my first answer', true],
            ['my second answer', true],
            ['my third answer', false],
            ['my fourth answer', false],
        ]);

        $this->question = new Question('my question', 'my category', $this->answers);
    }

    /**
     * Tests getters and setters
     */
    public function testGettersSetters()
    {
        $this->assertEquals('my category', $this->question->getCategory());
        $this->assertEquals('my question', $this->question->getQuestion());

        $this->assertEquals($this->answers, $this->question->getAnswers());

        $this->assertEquals(
            ['my first answer', 'my second answer', 'my third answer', 'my fourth answer'],
            $this->question->getAnswersLabels(),
            'Question should return all available answers labels'
        );
        $this->assertEquals(
            ['my first answer', 'my second answer'],
            $this->question->getCorrectAnswersValues(),
            'Question should return all correct answers values'
        );
    }

    /**
     * Tests areCorrectAnswers() method
     */
    public function testAreCorrectAnswers()
    {
        $this->assertTrue($this->question->areCorrectAnswers(
            ['my first answer', 'my second answer']
        ));

        $this->assertTrue($this->question->areCorrectAnswers(
            ['my second answer', 'my first answer']
        ));

        $this->assertFalse($this->question->areCorrectAnswers(
            ['my first answer']
        ));

        $this->assertFalse($this->question->areCorrectAnswers(
            ['my second answer']
        ));
        
        $this->assertFalse($this->question->areCorrectAnswers(
            ['my second answer', 'my third answer']
        ));

        $this->assertFalse($this->question->areCorrectAnswers([]));
    }

    /**
     * Tests isMultipleChoice() method
     */
    public function testIsMultipleChoice()
    {
        $multipleChoiceAnswers = self::answersFromArray([
            ['my first answer', true],
            ['my second answer', true],
            ['my third answer', false],
        ]);
        $nonMultipleChoiceAnswers = self::answersFromArray([
            ['my first answer', true],
            ['my second answer', false],
            ['my third answer', false],
        ]);

        $multipleChoiceQuestion = new Question('my question', 'my category', $multipleChoiceAnswers);
        $this->assertTrue($multipleChoiceQuestion->isMultipleChoice());
        $nonMultipleChoiceQuestion = new Question('my question', 'my category', $nonMultipleChoiceAnswers);
        $this->assertFalse($nonMultipleChoiceQuestion->isMultipleChoice());
    }
}