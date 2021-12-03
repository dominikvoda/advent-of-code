<?php declare(strict_types = 1);

namespace AdventOfCode\Generator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateSolutionClassesCommand extends Command
{
    private const DAY = 'day';
    private const SEASON = 'season';
    private const DEFAULT_SEASON = 2021;


    public function configure(): void
    {
        $this->setName('generate');
        $this->addArgument(self::DAY, InputArgument::REQUIRED);
        $this->addArgument(
            self::SEASON,
            InputArgument::OPTIONAL,
            'Event season',
            self::DEFAULT_SEASON
        );
    }


    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $day = (int)$input->getArgument(self::DAY);
        $season = (int)$input->getArgument(self::SEASON);

        $generator = new Generator();

        $generator->generateSolutionClasses($season, $day);

        $output->writeln('Generated.');

        return 0;
    }
}
