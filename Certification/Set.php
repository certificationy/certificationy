<?php

/*
 * This file is part of the Certificationy application.
 *
 * (c) Vincent Composieux <vincent.composieux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Certificationy\Certification;

/**
 * Class Set
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class Set
{
    /**
     * @var array
     */
    protected $questions;

    /**
     * @var array
     */
    protected $answers;

    /**
     * Constructor
     *
     * @param array $questions
     */
    public function __construct(array $questions)
    {
        $this->questions = $questions;
    }

    /**
     * Returns questions
     *
     * @return array
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Add a user answer
     *
     * @param integer $key
     * @param array   $answer
     */
    public function addAnswer($key, $answer)
    {
        $this->answers[$key] = $answer;
    }

    /**
     * Returns a user answers by question key
     *
     * @param integer $key
     *
     * @return null
     */
    public function getAnswer($key)
    {
        return isset($this->answers[$key]) ? $this->answers[$key] : null;
    }

    /**
     * Returns user answers
     *
     * @return array
     */
    public function getAnswers()
    {
        return $this->answers;
    }
}