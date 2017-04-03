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

use Certificationy\Interfaces\AnswerInterface;

class Answer implements AnswerInterface
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var bool
     */
    protected $correct;

    /**
     * Constructor
     *
     * @param string $value
     * @param bool   $correct
     */
    public function __construct($value, $correct)
    {
        $this->value   = $value;
        $this->correct = $correct;
    }

    /**
     * @inheritdoc
     */
    public function getValue() : string
    {
        return $this->value;
    }

    /**
     * @inheritdoc
     */
    public function isCorrect() : bool
    {
        return $this->correct;
    }
}
