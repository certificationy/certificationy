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

use Certificationy\Certification\Loader;
use Certificationy\Certification\Set;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

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
            ->addOption('list', 'l', InputOption::VALUE_NONE, 'List categories')
            ->addArgument('categories', InputArgument::IS_ARRAY, 'Which categories do you want (separate multiple with a space)', array())
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('list')) {
            $output->writeln(Loader::getCategories());
            return ;
        }
        
        $number = $input->getOption('number');
        $output->writeln(sprintf('Starting a new set of <info>%s</info> questions', $number));

        $set = Loader::init($number, $input->getArgument('categories'));

        $this->askQuestions($set, $input, $output);

        $this->displayResults($set, $output);
    }

    /**
     * Ask questions
     *
     * @param Set             $set    A Certificationy questions Set instance
     * @param InputInterface  $input  A Symfony Console input instance
     * @param OutputInterface $output A Symfony Console output instance
     */
    protected function askQuestions(Set $set, InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getHelper('question');

        $questionCount = 1;

        foreach($set->getQuestions() as $i => $question) {
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

            $output->writeln('<comment>✎ Your answer</comment>: ' . implode(', ', $key) . "\n");
        }
    }

    /**
     * Returns results
     *
     * @param Set             $set    A Certificationy questions Set instance
     * @param OutputInterface $output A Symfony Console output instance
     */
    protected function displayResults(Set $set, OutputInterface $output)
    {
        $results = array();

        foreach($set->getQuestions() as $key => $question) {
            $isCorrect = $set->isCorrect($key);

            $results[] = array(
                $question->getQuestion(),
                implode(', ', $question->getCorrectAnswersValues()),
                $isCorrect ? '<info>✔</info>' : '<error>✗</error>'
            );
        }

        $tableHelper = $this->getHelper('table');
        $tableHelper
            ->setHeaders(array('Question', 'Correct answer', 'Result'))
            ->setRows($results)
        ;

        $tableHelper->render($output);

        $output->writeln(
            sprintf('<comment>Results</comment>: <error>errors: %s</error> - <info>correct: %s</info>', $set->getErrorsNumber(), $set->getValidNumber())
        );
    }
}
