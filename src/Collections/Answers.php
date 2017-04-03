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

namespace Certificationy\Collections;

use Certificationy\Interfaces\AnswerInterface;

/**
 * Class Answers
 *
 * @author Mickaël Andrieu <andrieu.travail@gmail.com>
 */
final class Answers
{
    private $answers = [];

    public function __construct(array $answers = [])
    {
        foreach ($answers as $answer) {
            $this->addAnswer($answer);
        }
    }

    public function addAnswer(AnswerInterface $answer)
    {
        $this->answers[] = $answer;
    }

    public function addAnswers(array $answers)
    {
        foreach ($answers as $answer) {
            $this->addAnswer($answer);
        }

        return $this;
    }

    public function all()
    {
        return $this->answers;
    }

    public function count() : int
    {
        return count($this->answers);
    }

    public function shuffle()
    {
        shuffle($this->answers);

        return $this;
    }
}
