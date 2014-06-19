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
 * Class Question
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class Question
{
    /**
     * @var string
     */
    protected $question;

    /**
     * @var string
     */
    protected $category;

    /**
     * @var array
     */
    protected $answers;

    /**
     * @var bool
     */
    protected $multipleChoice;

    /**
     * Constructor
     *
     * @param string $question
     * @param string $category
     * @param array  $answers
     */
    public function __construct($question, $category, array $answers)
    {
        $this->question       = $question;
        $this->category       = $category;
        $this->answers        = $answers;
        $this->multipleChoice = count($this->getCorrectAnswersValues()) > 1 ? true : false;
    }

    /**
     * Returns question label
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Returns question category name
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Returns question available answers
     *
     * @return array
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Returns question correct answers values
     *
     * @return array
     */
    public function getCorrectAnswersValues()
    {
        $answers = array();

        foreach ($this->getAnswers() as $answer) {
            if ($answer->isCorrect()) {
                $answers[] = $answer->getValue();
            }
        }

        return $answers;
    }

    /**
     * Returns if given answers are correct answers
     *
     * @param array $answers
     *
     * @return bool
     */
    public function areCorrectAnswers(array $answers)
    {
        if (!$answers) {
            return false;
        }

        $correctAnswers = $this->getCorrectAnswersValues();

        if (count($correctAnswers) != count($answers)) {
            return false;
        }

        foreach ($answers as $answer) {
            if (!in_array($answer, $correctAnswers)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns question available answers labels
     *
     * @return array
     */
    public function getAnswersLabels()
    {
        $answers = array();

        foreach ($this->getAnswers() as $answer) {
            $answers[] = $answer->getValue();
        }

        return $answers;
    }

    /**
     * Returns whether multiple answers are correct for this question
     *
     * @return bool
     */
    public function isMultipleChoice()
    {
        return $this->multipleChoice;
    }
}
