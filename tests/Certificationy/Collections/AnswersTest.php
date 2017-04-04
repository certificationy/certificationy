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

use Certificationy\Collections\Answers;
use Tests\Certificationy\TestCase;

class AnswersTest extends TestCase
{
    private $answers;

    public function setUp()
    {
        $this->answers = self::answersFromArray([
            ['a', true],
            ['b', false],
            ['c', false],
        ]);
    }

    public function testIteratorInterface()
    {
        $this->assertInstanceOf(Answers::class, $this->answers);
        $this->assertInstanceOf(\Iterator::class, $this->answers);

        foreach ($this->answers as $answer) {
            $this->assertEquals('a', $answer->getValue());
            $this->assertTrue($answer->isCorrect());
            break;
        }
    }

    public function testCountableInterface()
    {
        $this->assertInstanceOf(\Countable::class, $this->answers);

        $this->assertEquals(3, count($this->answers));
    }
}
