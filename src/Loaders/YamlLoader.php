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
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class YamlLoader implements LoaderInterface
{
    /**
     * @var Questions
     */
    private $questions;

    /**
     * @var string
     */
    private $paths;

    public function __construct(array $paths)
    {
        $this->paths = $paths;
    }

    /**
     * @inheritdoc
     */
    public function initSet(int $nbQuestions, array $categories) : Set
    {
        $data = $this->prepareFromYaml($categories, $this->paths);

        if (!$data) {
            // throw an exception
            return new Set(array());
        }

        $dataMax = count($data) - 1;

        $questions = new Questions();

        for ($i = 0; $i < $nbQuestions; $i++) {
            do {
                $random = rand(0, $dataMax);
            } while ($questions->has($random) && $questions->count() < $dataMax);

            $item = $data[$random];

            $answers = new Answers();

            foreach ($item['answers'] as $key => $dataAnswer) {
                $answers->addAnswer($key, new Answer($dataAnswer['value'], $dataAnswer['correct']));
            }

            if (!isset($item['shuffle']) || true === $item['shuffle']) {
                $answers->shuffle();
            }

            $help = isset($item['help']) ? $item['help'] : null;

            $questions->add($random, new Question($item['question'], $item['category'], $answers, $help));
        }

        return new Set($questions);
    }

    /**
     * @inheritdoc
     *
     * @throws \ErrorException
     */
    public function all() : Questions
    {
        if (is_null($this->questions)) {
            throw new \ErrorException('Questions were not loaded');
        }

        return $this->questions;
    }

    /**
     * Get list of all categories
     *
     * @param string $path
     *
     * @return array
     */
    public function getCategories()
    {
        $categories = array();
        $files = $this->prepareFromYaml(array());

        foreach ($files as $file) {
            $categories[] = $file['category'];
        }

        return array_unique($categories);
    }

    /**
     * Prepares data from Yaml files and returns an array of questions
     *
     * @param array $categories : List of categories which should be included, empty array = all
     *
     * @return array
     */
    protected function prepareFromYaml(array $categories = array())
    {
        $data = array();

        foreach ($this->paths as $path) {
            $files = Finder::create()->files()->in($path)->name('*.yml');

            foreach ($files as $file) {
                $fileData = Yaml::parse($file->getContents());

                $category = $fileData['category'];
                if (count($categories) == 0 || in_array($category, $categories)) {
                    array_walk($fileData['questions'], function (&$item) use ($category) {
                        $item['category'] = $category;
                    });

                    $data = array_merge($data, $fileData['questions']);
                }
            }
        }

        return $data;
    }
}