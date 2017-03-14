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

namespace Certificationy;

use Certificationy\Collections\Answers;
use Certificationy\Collections\Questions;
use Certificationy\Interfaces\QuestionInterface;
use Certificationy\Interfaces\SetInterface;

class Set implements SetInterface
{
    /**
     * @var Questions
     */
    protected $questions;

    /**
     * @var Answers
     */
    protected $answers;

    public function __construct(Questions $questions)
    {
        $this->questions = $questions;
        $this->answers = new Answers();
    }

    /**
     * @inheritdoc
     */
    public function getQuestion(int $key) : QuestionInterface
    {
        return $this->questions->get($key);
    }

    /**
     * @inheritdoc
     */
    public function getQuestions() : Questions
    {
        return $this->questions;
    }

    /**
     * @inheritdoc
     */
    public function setAnswers(int $key, Answers $answers) : SetInterface
    {
        $this->answers->add($key, $answers);
    }

    /**
     * @inheritdoc
     */
    public function getQuestionAnswers(int $key) : Answers
    {
        return $this->answers->get($key);
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
    public function isCorrect(int $key) : bool
    {
        $question = $this->questions->get($key);
        $answers  = $this->answers->getAnswers($key);

        return $question->areCorrectAnswers($answers);
    }

    /**
     * @inheritdoc
     */
    public function getCorrectAnswers() : Questions
    {
        $questions = new Questions();

        foreach ($this->getQuestions() as $key => $question) {
            $question = $this->getQuestion($key);
            $answers  = $this->getAnswer($key);

            if ($question->areCorrectAnswers($answers)) {
                $questions->add($question);
            }
        }

        return $questions;
    }

    /**
     * @inheritdoc
     */
    public function getWrongAnswers() : Questions
    {
        $questions = new Questions();

        foreach ($this->getQuestions() as $key => $question) {
            $question = $this->getQuestion($key);
            $answers  = $this->getAnswer($key);

            if (!$question->areCorrectAnswers($answers)) {
                $questions->add($question);
            }
        }

        return $questions;
    }
}
