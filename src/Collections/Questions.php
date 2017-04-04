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

/**
 * Class Questions
 *
 * @author Mickaël Andrieu <andrieu.travail@gmail.com>
 */
final class Questions implements \Iterator, \Countable
{
    private $questions = [];
    private $index = 0;

    public function __construct(array $questions = [])
    {
        foreach ($questions as $index => $question) {
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

    public function get(int $key) : QuestionInterface
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

    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->questions[$this->index];
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        ++$this->index;
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return array_key_exists($this->index, $this->questions);
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->index = 0;
    }
}
