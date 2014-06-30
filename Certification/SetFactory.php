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
 * SetFactory
 *
 * @author Cas Leentfaar <info@casleentfaar.com>
 */
class SetFactory
{
    /**
     * @var QuestionLoader
     */
    protected $loader;

    /**
     * @param QuestionLoader $loader
     */
    public function __construct(QuestionLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Creates a new set of randomized questions
     *
     * @param integer $number     The number of questions to add to the set
     * @param array   $categories Categories to include in this set, leave empty to include all categories
     * @param bool    $randomized If true, the questions in the set will be randomized for a bigger challenge
     *
     * @return Set
     *
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function create($number, array $categories = array(), $randomized = false)
    {
        if (!is_numeric($number) || $number < 0) {
            throw new \InvalidArgumentException(sprintf('Must supply a (positive) numeric value for the number of questions, %s given', $number));
        }

        $questions = $this->createQuestions($categories, $randomized);

        // check if we have enough questions to meet the required number
        $numberOfQuestions = count($questions);
        if ($numberOfQuestions < $number) {
            if (empty($categories)) {
                throw new \LogicException(sprintf('There are not enough questions to meet the required number (required: %d, available: %d)', $number, $numberOfQuestions));
            } else {
                throw new \LogicException(sprintf('There are not enough questions with one of the given categories to meet the required number (required: %d, available: %d with categories: %s)', $number, $numberOfQuestions, implode(',', $categories)));
            }
        }

        $questions = array_slice($questions, 0, $number, true);
        if ($randomized === true) {
            shuffle($questions);
        }

        return new Set($questions);
    }

    /**
     * Creates an array of Question instances matching one of the given categories
     *
     * @param array $categories Categories to include in this set (case-insensitive),
     *                          leave empty to include all categories
     * @param bool  $randomized If true, the questions in the set will be randomized for a bigger challenge
     *
     * @return array
     */
    protected function createQuestions(array $categories = array(), $randomized = false)
    {
        $filteredQuestions = array();
        $categories        = array_map('strtolower', $categories);

        // filter all available questions down to those having one of the given categories
        foreach ($this->loader->getData() as $category => $categoryData) {
            if (empty($categories) || in_array(strtolower($category), $categories)) {
                foreach ($categoryData['questions'] as $questionData) {
                    if ($randomized === true) {
                        shuffle($questionData['answers']);
                    }
                    $filteredQuestions[] = new Question($questionData['question'], $category, $questionData['answers'], $questionData['weight']);
                }
            }
        }

        return $filteredQuestions;
    }
}
