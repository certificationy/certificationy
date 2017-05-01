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

use Certificationy\Interfaces\UserAnswerInterface;
use Certificationy\Exceptions\NotReachableEntry;
use Certificationy\UserAnswer;

/**
 * Class Answers
 *
 * @author Mickaël Andrieu <andrieu.travail@gmail.com>
 */
final class UserAnswers implements \Countable, \Iterator
{
    private $userAnswers = [];
    private $index;
    
    public function addAnswers(int $questionKey, array $answerValues) : UserAnswers
    {
        $this->removeByKey($questionKey);
        foreach ($answerValues as $answerValue) {
            $this->userAnswers[] = UserAnswer::create($questionKey, $answerValue);
        }

        return $this;
    }

    public function all()
    {
        return $this->userAnswers;
    }

    public function get(int $questionKey) : UserAnswerInterface
    {
        foreach ($this->userAnswers as $userAnswer) {
            if ($questionKey === $userAnswer->getKey()) {
                return $userAnswer;
            }
        }

        NotReachableEntry::create($questionKey);
    }

    public function getAnswersValues(int $questionKey) : array
    {
        $answers = [];

        foreach ($this->userAnswers as $userAnswer) {
            if ($questionKey === $userAnswer->getKey()) {
                $answers[] = $userAnswer->getValue();
            }
        }

        return $answers;
    }

    public function removeByKey(int $questionKey) : bool
    {
        $removed = false;
        foreach ($this->userAnswers as $index => $userAnswer) {
            if ($questionKey === $userAnswer->getKey()) {
                $removed = true;
                unset($this->userAnswers[$index]);
            }
        }

        return $removed;
    }

    public function count() : int
    {
        return count($this->userAnswers);
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->userAnswers[$this->index];
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        ++$this->index;
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return array_key_exists($this->index, $this->userAnswers);
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->index = 0;
    }
}
