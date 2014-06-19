<?php

/*
 * This file is part of the Certificationy application.
 *
 * (c) Vincent Composieux <vincent.composieux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Certificationy\Certification;

/**
 * Class Answer
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class Answer
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
     * Returns answer value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns if answer is correct
     *
     * @return bool
     */
    public function isCorrect()
    {
        return $this->correct;
    }
}
