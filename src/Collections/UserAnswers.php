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

namespace Certificationy\Collections;

use Certificationy\UserAnswer;
use Certificationy\Exceptions\NotReachableEntry;

/**
 * Class Answers
 *
 * @author Mickaël Andrieu <andrieu.travail@gmail.com>
 */
final class UserAnswers
{
    private $userAnswers;
    
    public function addAnswers(int $questionKey, array $answerValues) : UserAnswers
    {
        foreach ($answerValues as $answerValue) {
            $this->userAnswers[] = UserAnswer::create($questionKey, $answerValue);
        }

        return $this;
    }

    public function all()
    {
        return $this->userAnswers;
    }

    public function get(int $questionKey) : UserAnswer
    {
        if (!isset($this->userAnswers[$questionKey])) {
            NotReachableEntry::create($questionKey);
        }
        return $this->userAnswers[$questionKey];
    }

    public function count()
    {
        return count($this->userAnswers);
    }
}
