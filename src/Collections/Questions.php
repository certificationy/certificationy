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
use Certificationy\Interfaces\QuestionInterface;
use Certificationy\Question;

/**
 * Class Questions
 *
 * @author Mickaël Andrieu <andrieu.travail@gmail.com>
 */
final class Questions
{
    private $questions = [];

    public function __construct(array $questions = [])
    {
        foreach($questions as $index => $question) {
            $this->add($index, $question);
        }
    }

    public function all()
    {
        return $this->questions;
    }

    public function add(int $index, QuestionInterface $question)
    {
        $this->questions[$index] = $question;

        return $this;
    }

    public function count() : int
    {
        return count($this->questions);
    }

    public function get(int $key) : Question
    {
        if (!isset($this->questions[$key])) {
            NotReachableEntry::create($key);
        }

        return $this->questions[$key];
    }

    public function has(int $key) : bool
    {
        return isset($this->questions[$key]);
    }
}