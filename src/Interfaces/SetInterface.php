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

namespace Certificationy\Interfaces;

use Certificationy\Collections\Answers;
use Certificationy\Collections\Questions;
use Certificationy\Collections\UserAnswers;

interface SetInterface
{
    /**
     * Returns a question
     */
    public function getQuestion(int $key) : QuestionInterface;

    /**
     * Returns questions
     */
    public function getQuestions() : Questions;

    /**
     * Returns a user answers by question key
     */
    public function getQuestionAnswers(int $key) : Answers;

    /**
     * Returns user answer by question key
     */
    public function getAnswer(int $questionKey) : UserAnswerInterface;
    
    /**
     * Returns user answers
     */
    public function getAnswers() : UserAnswers;

    /**
     * Sets a user answers
     */
    public function setUserAnswers(int $questionKey, array $answers): SetInterface;

    /**
     * Returns if given question key user answers are correct
     */
    public function isCorrect(int $key) : bool;

    /**
     * Returns valid questions set number
     */
    public function getCorrectAnswers() : Questions;

    /**
     * Returns errors questions set number
     */
    public function getWrongAnswers() : Questions;
}
