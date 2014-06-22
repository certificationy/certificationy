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
     * @var Question[]
     */
    protected $questions;

    /**
     * @var array
     */
    protected $answers;

    /**
     * Constructor
     *
     * @param Question[] $questions
     */
    public function __construct(array $questions)
    {
        $this->questions = $questions;
    }

    /**
     * Returns a question
     *
     * @param int $key
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
     * @return Question[]
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Add a user answer
     *
     * @param int   $key    An identifier
     * @param array $answer A user answers array
     */
    public function addAnswer($key, $answer)
    {
        $this->answers[$key] = $answer;
    }

    /**
     * Returns a user answers by question key
     *
     * @param int $key
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
     * @param int $key
     *
     * @return bool
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
     * @return int
     */
    public function getValidNumber()
    {
        $count = 0;

        foreach ($this->getQuestions() as $key => $question) {
            $question = $this->getQuestion($key);
            $answers  = $this->getAnswer($key);

            if ($answers !== null) {
                if ($question->areCorrectAnswers($answers)) {
                    $count++;
                }
            }
        }

        return $count;
    }

    /**
     * Returns errors questions set number
     *
     * @return int
     */
    public function getErrorsNumber()
    {
        return count($this->getQuestions()) - $this->getValidNumber();
    }
}
