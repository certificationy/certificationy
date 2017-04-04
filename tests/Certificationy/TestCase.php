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

namespace Tests\Certificationy;

use Certificationy\Answer;
use Certificationy\Question;
use Certificationy\Collections\Answers;
use Certificationy\Collections\Questions;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public static function answersFromArray(array $answersData) : Answers
    {
        $answers = [];
        foreach ($answersData as $answerData) {
            $answers[] = new Answer($answerData[0], $answerData[1]);
        }

        return new Answers($answers);
    }

    public static function questionsFromArray(array $questionsData) : Questions
    {
        $questions = [];
        foreach ($questionsData as $questionData) {
            $questions[] = new Question($questionData[0], $questionData[1], $questionData[2]);
        }

        return new Questions($questions);
    }
}
