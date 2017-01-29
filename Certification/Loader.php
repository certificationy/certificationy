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

use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Loader
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class Loader
{
    /**
     * @var integer
     */
    public static $count = null;

    /**
     * Returns a new set of randomized questions
     *
     * @param integer $number
     * @param array   $categories
     * @param string  $path
     *
     * @return Set
     */
    public static function init($number, array $categories, $path)
    {
        $data = self::prepareFromYaml($categories, $path);

        if (!$data) {
            return new Set(array());
        }

        $dataMax = count($data) - 1;

        $questions = array();

        for ($i = 0; $i < $number; $i++) {
            do {
                $random = rand(0, $dataMax);
            } while (isset($questions[$random]) && count($questions) < $dataMax);

            $item = $data[$random];

            $answers = array();

            foreach ($item['answers'] as $dataAnswer) {
                $answers[] = new Answer($dataAnswer['value'], $dataAnswer['correct']);
            }

            if (!isset($item['shuffle']) || true === $item['shuffle']) {
                shuffle($answers);
            }

            $versions = isset($item['versions']) ? $item['versions']: array();
            $help = isset($item['help']) ? $item['help']: null;

            $questions[$random] = new Question($item['question'], $item['category'], $answers, $versions, $help);
        }

        return new Set($questions);
    }

    /**
     * Counts total of available questions
     *
     * @return integer
     * @throws \ErrorException
     */
    public static function count()
    {
        if (is_null(self::$count)) {
            throw new \ErrorException('Questions were not loaded');
        }

        return self::$count;
    }

    /**
     * Get list of all categories
     *
     * @param string $path
     *
     * @return array
     */
    public static function getCategories($path)
    {
        $categories = array();
        $files = self::prepareFromYaml(array(), $path);

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
    protected static function prepareFromYaml(array $categories = array(), $path)
    {
        $data = array();
        self::$count = 0;
        $paths = Yaml::parse(file_get_contents($path))['paths'];

        foreach ($paths as $path) {
            $files = Finder::create()->files()->in($path)->name('*.yml');

            foreach ($files as $file) {
                $fileData = Yaml::parse($file->getContents());

                $category = $fileData['category'];
                if (count($categories) == 0 || in_array($category, $categories)) {
                    array_walk($fileData['questions'], function (&$item, $key) use ($category) {
                        $item['category'] = $category;
                    });

                    $data = array_merge($data, $fileData['questions']);
                }
            }
        }
        self::$count = count($data);

        return $data;
    }
}
