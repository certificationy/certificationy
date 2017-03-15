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

use Certificationy\Interfaces\UserAnswerInterface;

class UserAnswer implements UserAnswerInterface
{
    private $questionKey;
    private $answerValue;
    
    public function __construct(int $questionKey, string $answerValue)
    {
        $this->questionKey = $questionKey;
        $this->answerValue = $answerValue;
    }
    
    public function getKey() : int
    {
        return $this->questionKey;
    }
    
    public function getValue() : string
    {
        return $this->answerValue;
    }
    
    public static function create(int $questionKey, string $answerValue)
    {
        return new self($questionKey, $answerValue);
    }
}