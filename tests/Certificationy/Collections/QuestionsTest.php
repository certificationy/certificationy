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

namespace Tests\Certificationy\Collections;

use Certificationy\Collections\Questions;
use Tests\Certificationy\TestCase;

class QuestionsTest extends TestCase
{
    private $questions;

    public function setUp()
    {
        return $this->questions = self::questionsFromArray([
            [
                'Q1?',
                'Common',
                self::answersFromArray([
                    ['a', true],
                    ['b', false],
                ])
            ], [
                'Q2?',
                'Common',
                self::answersFromArray([
                    ['1', false],
                    ['2', true],
                ])
            ]
        ]);
    }

    public function testIteratorInterface()
    {
        $this->assertInstanceOf(Questions::class, $this->questions);
        $this->assertInstanceOf(\Iterator::class, $this->questions);

        foreach ($this->questions as $question) {
            $this->assertEquals('Q1?', $question->getQuestion());
            $this->assertEquals('Common', $question->getCategory());
            break;
        }
    }

    public function testCountableInterface()
    {
        $this->assertInstanceOf(\Countable::class, $this->questions);

        $this->assertEquals(2, count($this->questions));
    }
}
