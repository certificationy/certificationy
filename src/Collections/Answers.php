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

use Certificationy\Exceptions\NotReachableEntry;
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
        foreach($answers as $index => $answer) {
            $this->addAnswer($index, $answer);
        }
    }

    public function all()
    {
        return $this->answers;
    }

    public function addAnswers(int $index, array $answers)
    {
        foreach($answers as $answer) {
            $this->addAnswer($index, $answer);
        }

        return $this;
    }

    public function count() : int
    {
        return count($this->answers);
    }

    public function getAnswers(int $key) : Answers
    {
        if (!isset($this->answers[$key])) {
            NotReachableEntry::create($key);
        }

        return $this->answers[$key];
    }

    public function addAnswer(int $index, AnswerInterface $answer)
    {
        $this->answers[$index][] = $answer;
    }

    public function shuffle()
    {
        shuffle($this->answers);

        return $this;
    }

    public function get(int $key) : Answer
    {
        if (!isset($this->answers[$key])) {
            NotReachableEntry::create($key);
        }

        return $this->answers[$key];
    }
}