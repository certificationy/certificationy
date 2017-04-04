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

use Certificationy\Collections\UserAnswers;
use Tests\Certificationy\TestCase;

class UserAnswersTest extends TestCase
{
    private $userAnswers;

    public function setUp()
    {
        $this->userAnswers = new UserAnswers();
        $this->userAnswers->addAnswers(0, ['a', 'b']);
    }

    public function testIteratorInterface()
    {
        $this->assertInstanceOf(UserAnswers::class, $this->userAnswers);
        $this->assertInstanceOf(\Iterator::class, $this->userAnswers);

        foreach ($this->userAnswers as $userAnswer) {
            $this->assertEquals('0', $userAnswer->getKey());
            $this->assertEquals('a', $userAnswer->getValue());
            break;
        }
    }

    public function testCountableInterface()
    {
        $this->assertInstanceOf(\Countable::class, $this->userAnswers);

        $this->assertEquals(2, count($this->userAnswers));
    }
}
