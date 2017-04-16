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

use Certificationy\Collections\Questions;

interface LoaderInterface
{
    /**
     * Load a filtered collection of Questions
     */
    public function load(int $nbQuestions, array $categories) : Questions;

    /**
     * Get list of all questions
     */
    public function all() : Questions;

    /**
     * Get list of all categories
     */
    public function categories() : array;
}
