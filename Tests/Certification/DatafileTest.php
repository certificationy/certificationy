<?php
/*
 * This file is part of the Certificationy application.
 *
 * (c) Vincent Composieux <vincent.composieux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Certification\Tests;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;

/**
 * DatafileTest
 *
 * @author Martin Aarhof <martin.aarhof@gmail.com>
 */
class DatafileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var array
     */
    private $_files = array();

    /**
     * Setup files
     *
     * @return void
     */
    public function setUp()
    {
        $finder = new Finder();
        $this->_files = $finder->files()->in(__DIR__ . '/../../vendor/certificationy/symfony-pack/data')->name('*.yml');
    }

    /**
     * Test that all data file is in the correct format
     *
     * @return void
     */
    public function testDatafileIntegrity()
    {
        foreach ($this->_files as $file) {
            /** @var SplFileInfo $file */
            $data = Yaml::parse($file->getContents());
            $this->assertArrayHasKey(
                'category',
                $data,
                sprintf('File "%s" does not have a category', $file->getFilename())
            );

            $this->assertArrayHasKey(
                'questions',
                $data,
                sprintf('File "%s" does not have questions', $file->getFilename())
            );
        }
    }

    /**
     * Test questions have answers
     *
     * @return void
     */
    public function testQuestionsHaveAnswers()
    {
        foreach ($this->_files as $file) {
            /** @var SplFileInfo $file */
            $data = Yaml::parse($file->getContents());

            $this->assertArrayHasKey(
                'questions',
                $data,
                sprintf(
                    'File "%s" does not have questions',
                    $file->getFilename()
                )
            );

            foreach ($data['questions'] as $num => $question) {
                $this->assertArrayHasKey(
                    'question',
                    $question,
                    sprintf(
                        'File "%s" - Question number "%d" does not have a question',
                        $file->getFilename(),
                        ($num + 1)
                    )
                );

                $this->assertArrayHasKey(
                    'answers',
                    $question,
                    sprintf(
                        'File "%s" - Question number "%d" does not have any answers',
                        $file->getFilename(),
                        ($num + 1)
                    )
                );
            }
        }
    }

    /**
     * Test question answers have minimum 1 correct answer
     *
     * @return void
     */
    public function testQuestionsHaveMinimumOneCorrectAnswer()
    {
        foreach ($this->_files as $file) {
            /** @var SplFileInfo $file */
            $data = Yaml::parse($file->getContents());
            foreach ($data['questions'] as $question) {
                if (isset($question['answers'])) {
                    foreach ($question['answers'] as $num => $answer) {
                        $this->assertArrayHasKey(
                            'value',
                            $answer,
                            sprintf(
                                'Answer number "%d" in
                                question "%s" does not have a value key',
                                ($num + 1),
                                $question['question']
                            )
                        );
                        $this->assertArrayHasKey(
                            'correct',
                            $answer,
                            sprintf(
                                'Answer number "%d" in
                                question "%s" does not have a correct key',
                                ($num + 1),
                                $question['question']
                            )
                        );

                        if (isset($answer['correct'])) {
                            if ($answer['correct'] === true) {
                                continue 2;
                            }
                        }
                    }

                    $this->fail(
                        sprintf(
                            'Question "%s" does not have a correct answer',
                            $question['question']
                        )
                    );

                }
            }
        }
    }
}
