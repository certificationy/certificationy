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
     * Returns a question
     *
     * @param integer $key
     *
     * @return Question|null
     */
    public function getQuestion($key)
    {
        return isset($this->questions[$key]) ? $this->questions[$key] : null;
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
     * @param integer $key    An identifier
     * @param array   $answer A user answers array
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
     * @return array|null
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

    /**
     * Returns if given question key user answers are correct
     *
     * @param integer $key
     *
     * @return boolean
     */
    public function isCorrect($key)
    {
        $question = $this->getQuestion($key);
        $answers  = $this->getAnswer($key);

        return $question->areCorrectAnswers($answers);
    }

    /**
     * Returns valid questions set number
     *
     * @return integer
     */
    public function getValidNumber()
    {
        $count = 0;

        foreach ($this->getQuestions() as $key => $question) {
            $question = $this->getQuestion($key);
            $answers  = $this->getAnswer($key);

            if ($question->areCorrectAnswers($answers)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Returns errors questions set number
     *
     * @return integer
     */
    public function getErrorsNumber()
    {
        return count($this->getQuestions()) - $this->getValidNumber();
    }
}