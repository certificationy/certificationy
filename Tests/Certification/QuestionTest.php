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

use Certificationy\Certification\Question;
use Certificationy\Certification\Answer;

/**
 * QuestionTest
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class QuestionTest extends \PHPUnit_Framework_TestCase
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
        $this->answers = array(
            new Answer('my first answer', true),
            new Answer('my second answer', true),
            new Answer('my third answer', false),
            new Answer('my fourth answer', false)
        );

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
            array('my first answer', 'my second answer', 'my third answer', 'my fourth answer'),
            $this->question->getAnswersLabels()
        );
        $this->assertEquals(
            array('my first answer', 'my second answer'),
            $this->question->getCorrectAnswersValues()
        );
    }

    /**
     * Tests areCorrectAnswers() method
     */
    public function testAreCorrectAnswers()
    {
        $this->assertTrue($this->question->areCorrectAnswers(
            array('my first answer', 'my second answer')
        ));

        $this->assertTrue($this->question->areCorrectAnswers(
            array('my second answer', 'my first answer')
        ));

        $this->assertFalse($this->question->areCorrectAnswers(
            array('my first answer')
        ));

        $this->assertFalse($this->question->areCorrectAnswers(
            array('my second answer')
        ));
        
        $this->assertFalse($this->question->areCorrectAnswers(
            array('my second answer', 'my third answer')
        ));

        $this->assertFalse($this->question->areCorrectAnswers(
            array()
        ));
    }

    /**
     * Tests isMultipleChoice() method
     */
    public function testIsMultipleChoice()
    {
        $multipleChoiceAnswers = array(
            new Answer('my first answer', true),
            new Answer('my second answer', true),
            new Answer('my third answer', false)
        );
        $nonMultipleChoiceAnswers = array(
            new Answer('my first answer', true),
            new Answer('my second answer', false),
            new Answer('my third answer', false)
        );

        $multipleChoiceQuestion = new Question('my question', 'my category', $multipleChoiceAnswers);
        $this->assertTrue($multipleChoiceQuestion->isMultipleChoice());
        $nonMultipleChoiceQuestion = new Question('my question', 'my category', $nonMultipleChoiceAnswers);
        $this->assertFalse($nonMultipleChoiceQuestion->isMultipleChoice());
    }
}