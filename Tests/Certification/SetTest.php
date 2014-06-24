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

use Certificationy\Certification\Answer;
use Certificationy\Certification\Set;
use Certificationy\Certification\Question;

/**
 * SetTest
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 * @author Cas Leentfaar <info@casleentfaar.com>
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
        foreach ($this->set->getQuestions() as $question) {
            $this->assertInstanceOf('Certificationy\Certification\Question', $question);
        }

        $this->assertInstanceOf('Certificationy\Certification\Question', $this->set->getQuestion(0));

        $this->assertEquals('my first question', $this->set->getQuestion(0)->getQuestion());
        $this->assertEquals('my second question', $this->set->getQuestion(1)->getQuestion());
    }

    /**
     * Tests the number of questions in a question set
     */
    public function testCount()
    {
        $this->assertCount(2, $this->set->getQuestions(), 'Should return 2 questions');
    }

    /**
     * Tests answers methods
     */
    public function testAnswers()
    {
        $answers = array(
            0 => array('my first answer'),
            1 => array('my second answer'),
        );

        $this->set->addAnswer(0, $answers[0]);
        $this->set->addAnswer(1, $answers[1]);

        $this->assertCount(2, $this->set->getAnswers());

        $this->assertEquals($answers[0], $this->set->getAnswer(0));
        $this->assertEquals($answers[1], $this->set->getAnswer(1));
    }

    /**
     * Tests the score calculated from a given set of answers
     *
     * @dataProvider getAnswersAndScores
     */
    public function testScore($actualAnswers, $expectedScore)
    {
        foreach ($actualAnswers as $x => $answer) {
            $answers = $answer;
            if (!is_array($answers)) {
                $answers = array($answers);
            }
            $this->set->addAnswer($x, $answers);
        }
        $this->assertEquals($expectedScore, $this->set->getScore());
    }

    /**
     * @return array
     */
    public function getAnswersAndScores()
    {
        return array(
            array(
                array(
                    0 => 'my first answer',
                    1 => 'my second answer',
                ),
                10.0
            ),
            array(
                array(
                    0 => 'my second answer',
                    1 => 'my second answer',
                ),
                5.0
            ),
            array(
                array(
                    0 => 'my second answer',
                    1 => 'my first answer',
                ),
                0.0
            ),
        );
    }
}
