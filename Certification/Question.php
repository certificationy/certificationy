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
 * @author Cas Leentfaar <info@casleentfaar.com>
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
     * @var float
     */
    protected $weight;

    /**
     * @var bool
     */
    protected $multipleChoice;

    /**
     * Constructor
     *
     * @param string $question The question string itself
     * @param string $category Category of the question
     * @param array  $answers  An array of the possible answers
     * @param float  $weight   Value between 0.0 and 1.0
     */
    public function __construct($question, $category, array $answers, $weight = 1.0)
    {
        $this->question       = $question;
        $this->category       = $category;
        $this->answers        = $answers;
        $this->weight         = $weight;
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
     * Returns the weight of this question
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Returns question available answers
     *
     * @return Answer[]
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
     * Returns the labels for this question's answers
     *
     * @return array
     */
    public function getAnswersLabels()
    {
        $answers = array();
        $i       = 0;
        foreach ($this->getAnswers() as $answer) {
            $answers[++$i] = $answer->getValue();
        }

        return $answers;
    }

    /**
     * @return bool True if multiple answers are correct, false otherwise
     */
    public function isMultipleChoice()
    {
        return $this->multipleChoice;
    }
}
