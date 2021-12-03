<?php declare(strict_types = 1);

namespace AdventOfCode;

use Nette\Utils\Strings;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use function assert;
use function sprintf;

class ResolveCommand extends Command
{
    private const DAY = 'day';
    private const PART = 'part';
    private const SEASON = 'season';
    private const FIRST_PART = 'first';
    private const SECOND_PART = 'second';
    private const DEFAULT_SEASON = 2021;


    public function configure(): void
    {
        $this->setName('resolve');
        $this->addArgument(self::DAY, InputArgument::REQUIRED);
        $this->addArgument(
            self::PART,
            InputArgument::OPTIONAL,
            'Part of the puzzle (first or second)',
            self::FIRST_PART
        );
        $this->addArgument(
            self::SEASON,
            InputArgument::OPTIONAL,
            'Event season',
            self::DEFAULT_SEASON
        );
    }


    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $puzzleSolutionClassName = $this->getPuzzleSolutionClass($input);

        $io = new SymfonyStyle($input, $output);

        if (!class_exists($puzzleSolutionClassName)) {
            $io->error(sprintf('Class %s not found', $puzzleSolutionClassName));

            return 1;
        }

        $puzzleSolution = new $puzzleSolutionClassName();
        assert($puzzleSolution instanceof PuzzleSolution);

        $io->success('Result: ' . $puzzleSolution->getResult()->toString());

        return 0;
    }


    private function getPuzzleSolutionClass(InputInterface $input): string
    {
        $day = $input->getArgument(self::DAY);
        $part = $input->getArgument(self::PART);
        $season = $input->getArgument(self::SEASON);

        return sprintf(
            'AdventOfCode\\Season%s\\Day%d\\PuzzleSolution%sPart',
            $season,
            $day,
            Strings::firstUpper($part)
        );
    }
}
