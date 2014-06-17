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
     * Returns a new set of randomized questions
     *
     * @param int $number
     *
     * @return Set
     */
    public static function init($number)
    {
        $data    = self::prepareFromYaml();
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

            shuffle($answers);

            $questions[$random] = new Question($item['question'], $item['category'], $answers);
        }

        return new Set($questions);
    }

    /**
     * Prepares data from Yaml files and returns an array of questions
     *
     * @return array
     */
    protected static function prepareFromYaml()
    {
        $files = Finder::create()->files()->in(__DIR__ . '/../data/')->name('*.yml');

        $data = array();

        foreach ($files as $file) {
            $fileData = Yaml::parse($file->getContents());

            $category = $fileData['category'];
            array_walk($fileData['questions'], function (&$item, $key) use ($category) {
                $item['category'] = $category;
            });

            $data = array_merge($data, $fileData['questions']);
        }

        return $data;
    }
}
