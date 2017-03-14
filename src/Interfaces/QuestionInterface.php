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

interface QuestionInterface
{
    /**
     * Returns question label
     */
    public function getQuestion() : string;

    /**
     * Returns question category name
     */
    public function getCategory() : string;

    /**
     * Returns question available answers
     */
    public function getAnswers() : Answers;

    /**
     * Returns question correct answers values
     */
    public function getCorrectAnswersValues() : array;

    /**
     * Returns if given answers are correct answers
     */
    public function areCorrectAnswers(Answers $answers) : bool;

    /**
     * Returns question available answers labels
     */
    public function getAnswersLabels() : array;

    /**
     * Returns whether multiple answers are correct for this question
     */
    public function isMultipleChoice() : bool;

    /**
     * Returns help message for answer
     */
    public function getHelp() : string;
}