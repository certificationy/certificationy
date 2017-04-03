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

use Certificationy\Answer;

class AnswerTest extends \PHPUnit\Framework\TestCase
{
    public function testGettersSetters()
    {
        $correctAnswer = new Answer('my first value', true);
        $wrongAnswer = new Answer('my second value', false);

        $this->assertEquals('my first value', $correctAnswer->getValue());
        $this->assertEquals('my second value', $wrongAnswer->getValue());

        $this->assertTrue($correctAnswer->isCorrect());
        $this->assertFalse($wrongAnswer->isCorrect());
    }
}
