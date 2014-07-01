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
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Yaml\Yaml;

/**
 * Class that loads question-structures from Yaml files and resolves it's contents
 *
 * @author Cas Leentfaar <info@casleentfaar.com>
 */
class QuestionLoader
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var OptionsResolver
     */
    protected $categoryResolver;

    /**
     * @var OptionsResolver
     */
    protected $questionResolver;

    /**
     * @param string|null $path Custom location of the files to load (.yaml)
     */
    public function __construct($path = null)
    {
        $this->categoryResolver = $this->createCategoryResolver();
        $this->questionResolver = $this->createQuestionResolver();
        $this->data             = $this->prepareData($path ? : __DIR__ . '/../data/');
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Returns an array of all available categories
     *
     * @return array
     */
    public function getCategories()
    {
        return array_keys($this->data);
    }

    /**
     * @return OptionsResolver
     */
    public function getCategoryResolver()
    {
        return $this->categoryResolver;
    }

    /**
     * @return OptionsResolver
     */
    public function getQuestionResolver()
    {
        return $this->questionResolver;
    }

    /**
     * Prepares data from .yml files found in the given path
     *
     * @param string $path The path to the yaml files
     *
     * @return array An array of all the questions and answers, indexed by their category
     */
    protected function prepareData($path)
    {
        $files = Finder::create()->files()->in($path)->name('*.yml');
        $data  = array();
        foreach ($files as $file) {
            $categoryData                    = $this->categoryResolver->resolve(Yaml::parse($file->getContents()));
            $data[$categoryData['category']] = $categoryData;
        }

        return $data;
    }

    /**
     * Creates an OptionsResolver instance configured to resolve options for a question category
     *
     * @return OptionsResolver
     */
    protected function createCategoryResolver()
    {
        $loader   = $this;
        $resolver = new OptionsResolver();
        $resolver->setRequired(array(
            'category',
            'questions',
        ));
        $resolver->setAllowedTypes(array(
            'category'  => 'string',
            'questions' => 'array',
        ));
        $resolver->setNormalizers(array(
            'questions' => function (Options $options, array $questions) use ($loader) {
                foreach ($questions as $x => $questionData) {
                    $questionData['category'] = $options->get('category');
                    $questions[$x]            = $loader->getQuestionResolver()->resolve($questionData);
                }

                return $questions;
            },
        ));

        return $resolver;
    }

    /**
     * Creates an OptionsResolver instance configured to resolve options for a question and it's answers
     *
     * @return OptionsResolver
     */
    protected function createQuestionResolver()
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired(array(
            'category',
            'question',
            'answers',
        ));
        $resolver->setOptional(array(
            'weight',
        ));
        $resolver->setAllowedTypes(array(
            'category' => array('string'),
            'question' => array('string'),
            'answers'  => array('array'),
            'weight'   => array('double', 'float'),
        ));
        $resolver->setDefaults(array(
            'weight' => 1.0,
        ));
        $resolver->setNormalizers(array(
            'answers' => function (Options $options, array $answers) {
                $answerObjects = array();
                foreach ($answers as $answerData) {
                    $answerObjects[] = new Answer($answerData['value'], $answerData['correct']);
                }

                return $answerObjects;
            },
        ));

        return $resolver;
    }
}
