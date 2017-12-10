<?php

namespace AOC2017;

use AOC2017\Days\DefaultDay;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ResolveCommand extends Command
{
    private const DAY_ARGUMENT = 'day';
    private const FIRST_OPTION = 'first';
    private const SECOND_OPTION = 'second';

    public function configure()
    {
        $this->setName('resolve');
        $this->addArgument(self::DAY_ARGUMENT, InputArgument::REQUIRED);
        $this->addOption(self::FIRST_OPTION, 'f', InputOption::VALUE_NONE);
        $this->addOption(self::SECOND_OPTION, 's', InputOption::VALUE_NONE);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     * @throws Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $dayNumber = $input->getArgument(self::DAY_ARGUMENT);
        $dayClass = sprintf('AOC2017\Days\Day%s', $dayNumber);
        $first = $input->getOption(self::FIRST_OPTION);
        $second = $input->getOption(self::SECOND_OPTION);
        $io = new SymfonyStyle($input, $output);

        if (class_exists($dayClass)) {
            /** @var DefaultDay $day */
            $day = new $dayClass();
            $input = $day->loadInput($dayNumber);
            $io->success('Input loaded');

            if (!$first && !$second) {
                $first = $second = true;
            }

            if ($first) {
                $io->title('First puzzle is resolving...');
                $start = microtime(true);
                $firstResult = $day->getFirstResult($input);
                $seconds = microtime(true) - $start;
                $io->success(sprintf('Result 1: %s', $firstResult));
                $io->comment(sprintf('Execution time: %f sec', $seconds));
            }
            if ($second) {
                $io->title('Second puzzle is resolving...');
                $start = microtime(true);
                $secondResult = $day->getSecondResult($input);
                $seconds = microtime(true) - $start;
                $io->success(sprintf('Result 2: %s', $secondResult));
                $io->comment(sprintf('Execution time: %f sec', $seconds));
            }
        } else {
            $io->error(sprintf('Class %s not found', $dayClass));
        }
    }
}
