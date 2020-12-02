<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ResolveCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('puzzle:resolve');
        $this->addArgument('day');
        $this->addOption('secondPart', 's', InputOption::VALUE_NONE);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day = $input->getArgument('day');
        $secondPart = $input->getOption('secondPart');

        $puzzleClass = 'AdventOfCode\Season2019\\Day' . $day.'\\Puzzle';

        /** @var PuzzleInterface $puzzle */
        $puzzle = new $puzzleClass($output);

        $result = $secondPart ? $puzzle->resolveSecondPart() : $puzzle->resolveFirstPart();

        $output->writeln('Result: ' . $result);

        return 0;
    }
}
