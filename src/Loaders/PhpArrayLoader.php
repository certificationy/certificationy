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

namespace Certificationy\Loaders;

use Certificationy\Interfaces\LoaderInterface;
use Certificationy\Collections\Questions;
use Certificationy\Collections\Answers;
use Certificationy\Answer;
use Certificationy\Question;
use Certificationy\Set;

/**
 * Able to import PHP array into a Set
 *
 * [
 *   [
 *     'question' => 'What is the best PHP framework?',
 *     'answers' => [
 *        [
 *          'value' => 'Laravel',
 *          'correct' => false
 *        ],
 *        [
 *          'value' => 'Symfony',
 *          'correct' => true
 *        ]
 *     ],
 *     'category' => 'PHP ecosystem'
 *   ]
 * ]
 */
class PhpArrayLoader implements LoaderInterface
{
    /**
     * @var Questions
     */
    private $questions;

    /**
     * @var array
     */
    private $questionsData;

    public function __construct(array $questionsData)
    {
        $this->questionsData = $questionsData;
    }

    /**
     * @inheritdoc
     */
    public function initSet(int $nbQuestions, array $categories = []) : Set
    {
        $questionsData = $this->questionsData;

        if (count($categories) > 0) {
            $questionsData = array_filter($questionsData, function($questionData) use ($categories) {
                return in_array($questionData['category'], $categories);
            });
        }

        $dataMax = count($questionsData) - 1;
        $questions = new Questions();

        for ($i = 0; $i < $nbQuestions; $i++) {
            do {
                $random = rand(0, $dataMax);
            } while ($questions->has($random) && $questions->count() <= $dataMax);

            $item = $questionsData[$random];
            $questions->add($random, $this->createFromEntry($item));
        }

        return new Set($questions);
    }

    /**
     * @inheritdoc
     */
    public function all() : Questions
    {
        if (null === $this->questions) {
            $questions = [];
            foreach ($this->questionsData as $questionData) {
                $questions[] = $this->createFromEntry($questionData);
            }
        }

        return $questions;
    }

    /**
     * @inheritdoc
     */
    public function categories() : array
    {
        foreach ($this->questionsData as $questionData) {
            $categories[] = $questionData['category'];
        }

        return  array_unique($categories);
    }

    private function createFromEntry(array $entry) : Question
    {
        $answers = new Answers();

        foreach ($entry['answers'] as $dataAnswer) {
            $answers->addAnswer(new Answer($dataAnswer['value'], $dataAnswer['correct']));
        }

        if (!isset($entry['shuffle']) || true === $entry['shuffle']) {
            $answers->shuffle();
        }

        $help = isset($entry['help']) ? $entry['help'] : null;

        return new Question($entry['question'], $entry['category'], $answers, $help);
    }
}