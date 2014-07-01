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

/**
 * AnswerTest
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class AnswerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests getters and setters
     */
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
