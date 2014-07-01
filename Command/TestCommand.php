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

use Certificationy\Certification\QuestionLoader;
use Certificationy\Certification\Set;
use Certificationy\Certification\SetFactory;
use Symfony\Component\Console\Command\Command;
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
class TestCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('test')
            ->setDescription('Starts a new test using random questions')
            ->addOption('categories', 'c', InputOption::VALUE_REQUIRED, 'Categories to include for this test (e.g. --categories=doctrine,twig,validation). By default, all categories are included', array())
            ->addOption('number', 'u', InputOption::VALUE_REQUIRED, 'The number of questions for this test.', 20)
            ->addOption('randomized', 'r', InputOption::VALUE_REQUIRED, 'Use this if you want the questions to be randomized.', true)
            ->addOption('show-multiple-choice', 'm', InputOption::VALUE_OPTIONAL, 'Should we tell you when the question is multiple choice?', true)
            ->addOption('list', 'l', InputOption::VALUE_NONE, 'Use this to list the available categories instead of starting a test.')
            ->addOption('env', 'e', InputOption::VALUE_REQUIRED, 'Current environment, mainly used to determine the location of the question files.', 'prod');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->isInteractive() !== true) {
            throw new \LogicException('This command can only be used interactively');
        }

        $path    = $input->getOption('env') === 'test' ? __DIR__ . '/../Tests/data/' : null;
        $loader  = new QuestionLoader($path);
        $factory = new SetFactory($loader);
        if ($input->getOption('list')) {
            $output->writeln($loader->getCategories());

            return;
        }

        $number     = $input->getOption('number');
        $randomized = (bool) $input->getOption('randomized');
        $categories = is_array($input->getOption('categories')) ? $input->getOption('categories') : explode(',', $input->getOption('categories'));
        $set        = $factory->create($number, $categories, $randomized);
        $output->writeln(sprintf('Starting a new set of <info>%s</info> questions', count($set->getQuestions())));

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
        $questionHelper     = $this->getHelper('question');
        $showMultipleChoice = $input->getOption('show-multiple-choice');
        $questionCount      = 1;

        foreach ($set->getQuestions() as $i => $question) {
            $choiceQuestion = new ChoiceQuestion(
                sprintf(
                    'Question <comment>#%d</comment> [<info>%s</info>] %s' .
                    ($showMultipleChoice === true && count($question->getAnswers()) > 2 ? "\n" . 'This question <comment>' . ($question->isMultipleChoice() === true ? 'IS' : 'IS NOT') . "</comment> multiple choice." : ""),
                    $questionCount++, $question->getCategory(), $question->getQuestion()
                ),
                $question->getAnswersLabels()
            );

            $multiSelect = $showMultipleChoice === true ? $question->isMultipleChoice() : true;
            $choiceQuestion->setMultiselect($multiSelect);
            $choiceQuestion->setErrorMessage('Answer %s is invalid.');

            $answer  = $questionHelper->ask($input, $output, $choiceQuestion);
            $answers = true === $multiSelect ? $answer : array($answer);
            $answer  = true === $multiSelect ? implode(', ', $answer) : $answer;

            $set->addAnswer($i, $answers);

            $output->writeln('<comment>✎ Your answer</comment>: ' . $answer . "\n");
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

        foreach ($set->getQuestions() as $key => $question) {
            $results[] = array(
                $question->getQuestion(),
                implode(', ', $question->getCorrectAnswersValues()),
                $set->isCorrect($key) ? '<info>✔</info>' : '<error>✗</error>'
            );
        }

        $score       = $set->getScore();
        $tableHelper = $this->getHelper('table');
        $tableHelper
            ->setHeaders(array('Question', 'Correct answer', 'Result'))
            ->setRows($results);

        $tableHelper->render($output);

        $output->writeln(sprintf('You scored: <comment>%d</comment>', $score));
        $output->writeln($this->getReaction($score));
        $output->writeln(sprintf(
            '<comment>Results</comment>: <error>incorrect: %s</error> - <info>correct: %s</info>',
            $set->getIncorrectNumber(),
            $set->getCorrectNumber()
        ));
    }

    /**
     * Returns a (CLI-styled) reaction from a given score to motivate the user with
     *
     * @param int $score
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function getReaction($score)
    {
        $floor = floor($score);

        switch ($floor) {
            case 0:
                return '<error>Wow... How did you do that? That\'s the worst score possible!</error>';
            case 1:
                return '<error>Okay... How did you even get this command to work?</error>';
            case 2:
                return '<error>I suppose you don\'t work with Symfony that often?</error>';
            case 3:
                return '<comment>Well... You have to start somewhere, right?</comment>';
            case 4:
                return '<comment>You still lack some Symfony experience!</comment>';
            case 5:
                return '<comment>Not bad... But you could do much better!</comment>';
            case 6:
                return '<comment>You are getting the hang of this! Keep it up!</comment>';
            case 7:
                return '<info>Well this test wasn\'t so hard for you, was it?</info>';
            case 8:
                return '<info>Wow... did you write the questions yourself?</info>';
            case 9:
                return '<info>Awesome! Care to go for a perfect score?</info>';
            case 10:
                return '<info>Perfect score! Congratulations! You are the king of your, eh... terminal session!</info>';
            default:
                throw new \InvalidArgumentException(sprintf('Can\'t determine reaction, floored score must be between 0 and 10: %d given', $floor));
        }
    }
}
