<?php

namespace AOC2017;

use AOC2017\Days\DefaultDay;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResolveCommand extends Command
{
    private const DAY_ARGUMENT = 'day';

    public function configure()
    {
        $this->setName('resolve');
        $this->addArgument(self::DAY_ARGUMENT, InputArgument::REQUIRED);
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

        if (class_exists($dayClass)) {
            /** @var DefaultDay $day */
            $day = new $dayClass();
            $output->writeln(sprintf('Result 1: %s', $day->getFirstResult($dayNumber)));
            $output->writeln(sprintf('Result 2: %s', $day->getSecondResult($dayNumber)));
        } else {
            $output->writeln(sprintf('Class %s not found', $dayClass));
        }
    }
}
