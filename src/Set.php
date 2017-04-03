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
use Certificationy\Collections\UserAnswers;
use Certificationy\Interfaces\AnswerInterface;
use Certificationy\Interfaces\QuestionInterface;
use Certificationy\Interfaces\UserAnswerInterface;
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
        $this->answers = new UserAnswers();
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
    public function setUserAnswers(int $questionKey, array $answers) : SetInterface
    {
        $this->answers->addAnswers($questionKey, $answers);
    
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getQuestionAnswers(int $key) : Answers
    {
        return $this->question->getAnswers()->get($key);
    }

    /**
     * @inheritdoc
     */
    public function getAnswer(int $questionKey) : UserAnswerInterface
    {
        return $this->answers->get($questionKey);
    }

    /**
     * @inheritdoc
     */
    public function getAnswers() : UserAnswers
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
