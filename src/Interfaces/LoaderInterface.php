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

use Certificationy\Set;
use Certificationy\Collections\Questions;

interface LoaderInterface
{
    /**
     * Setup the Set of questions
     */
    public function initSet(int $nbQuestions, array $categories) : Set;

    /**
     * Get list of all questions
     */
    public function all() : Questions;

    /**
     * Get list of all categories
     */
    public function categories() : array;
}
