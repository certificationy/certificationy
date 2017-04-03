<?php

/*
 * This file is part of the Certificationy application.
 *
 * (c) Vincent Composieux <vincent.composieux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Certificationy;

use Certificationy\Collections\Answers;
use Certificationy\Interfaces\QuestionInterface;

class Question implements QuestionInterface
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
     * @var Answers
     */
    protected $answers;

    /**
     * @var bool
     */
    protected $multipleChoice;

    /**
     * @var string
     */
    protected $help;

    /**
     * Constructor
     *
     * @param string      $question
     * @param string      $category
     * @param array       $answers
     * @param string|null $help
     */
    public function __construct(string $question, string $category, Answers $answers, $help = null)
    {
        $this->question       = $question;
        $this->category       = $category;
        $this->answers        = $answers;
        $this->multipleChoice = count($this->getCorrectAnswersValues()) > 1 ? true : false;
        $this->help           = $help;
    }

    /**
     * @inheritdoc
     */
    public function getQuestion() : string
    {
        return $this->question;
    }

    /**
     * @inheritdoc
     */
    public function getCategory() : string
    {
        return $this->category;
    }

    /**
     * @inheritdoc
     */
    public function getAnswers() : Answers
    {
        return $this->answers;
    }

    /**
     * @inheritdoc
     */
    public function getCorrectAnswersValues() : array
    {
        $answersValues = [];

        foreach ($this->answers->all() as $answer) {
            if ($answer->isCorrect()) {
                $answersValues[] = $answer->getValue();
            }
        }

        return $answersValues;
    }

    /**
     * @inheritdoc
     */
    public function areCorrectAnswers(array $answers) : bool
    {
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
     * @inheritdoc
     */
    public function getAnswersLabels() : array
    {
        $answers = [];

        foreach ($this->answers->all() as $answer) {
            $answers[] = $answer->getValue();
        }

        return $answers;
    }

    /**
     * @inheritdoc
     */
    public function isMultipleChoice() : bool
    {
        return $this->multipleChoice;
    }

    /**
     * @inheritdoc
     */
    public function getHelp() : string
    {
        return $this->help;
    }
}
