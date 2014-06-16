<?php

/*
 * This file is part of the Certificationy application.
 *
 * (c) Vincent Composieux <vincent.composieux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Certificationy\Command;

use Certificationy\Certification\Answer;
use Certificationy\Certification\Question;
use Certificationy\Certification\Set;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

/**
 * Class StartCommand
 *
 * This is the command to start a new questions set
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class StartCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('start')
            ->setDescription('Starts a new question set')
            ->addOption('number', null, InputOption::VALUE_OPTIONAL, 'How many questions do you want?', 20)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $number = $input->getOption('number');
        $output->writeln(sprintf('Starting a new set of <info>%s</info> questions', $number));

        $set = $this->prepareSet($number);

        $questionHelper = $this->getHelperSet()->get('question');

        // Ask questions
        $questions = $set->getQuestions();

        $questionCount = 1;

        foreach($questions as $i => $question) {
            $choiceQuestion = new ChoiceQuestion(
                sprintf(
                    'Question <comment>#%d</comment> [<info>%s</info>] %s',
                    $questionCount++, $question->getCategory(), $question->getQuestion()
                ),
                $question->getAnswersLabels()
            );

            $choiceQuestion->setMultiselect(true);
            $choiceQuestion->setErrorMessage('Answer %s is invalid.');

            $key = $questionHelper->ask($input, $output, $choiceQuestion);
            $set->addAnswer($i, $key);

            $output->writeln('<comment>✎ You answer</comment>: ' . implode(', ', $key) . "\n");
        }

        // Results
        $results = array();

        foreach($questions as $i => $question) {
            $answers = $set->getAnswer($i);

            $correctAnswers = $question->getCorrectAnswersValues();
            $isCorrect      = $question->areCorrectAnswers($answers);

            if (!$isCorrect) {
                $set->addError();
            }

            $results[] = array(
                $question->getQuestion(),
                implode(', ', $correctAnswers),
                $isCorrect ? '<info>✔</info>' : '<error>✗</error>'
            );
        }

        $tableHelper = $this->getHelperSet()->get('table');
        $tableHelper
            ->setHeaders(array('Question', 'Correct answer', 'Result'))
            ->setRows($results)
        ;

        $tableHelper->render($output);

        $output->writeln(
            sprintf('<comment>Results</comment>: <error>errors: %s</error> - <info>correct: %s</info>', $set->getErrors(), (count($questions) - $set->getErrors()))
        );
    }

    /**
     * Returns a new set of randomized questions
     *
     * @param integer $number
     *
     * @return Set
     */
    protected function prepareSet($number)
    {
        $data    = $this->prepareFromYaml();
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

            $questions[$random] = new Question($item['question'], $item['category'], $answers);
        }

        return new Set($questions);
    }

    /**
     * Prepares data from Yaml files and returns an array of questions
     *
     * @return array
     */
    protected function prepareFromYaml()
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
