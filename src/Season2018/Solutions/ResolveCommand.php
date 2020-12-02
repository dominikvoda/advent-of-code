<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Solutions;

use Nette\Utils\FileSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResolveCommand extends Command
{
    private const DAY_NUMBER = 'day-number';
    private const QUEST_NUMBER = 'quest-number';


    protected function configure(): void
    {
        $this->setName('resolve');
        $this->addArgument(self::DAY_NUMBER);
        $this->addArgument(self::QUEST_NUMBER);
    }


    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $day = 'Day' . $input->getArgument(self::DAY_NUMBER);
        $quest = $input->getArgument(self::QUEST_NUMBER) === '1' ? 'First' : 'Second';

        $resolverName = $quest . 'PartResolver';

        $resolverClass = 'AdventOfCode\Season2018\\Solutions\\' . $day . '\\' . $resolverName;

        $filePath = __DIR__ . '/' . $day . '/input.txt';

        /** @var ResolverInterface $resolver */
        $resolver = new $resolverClass();

        $result = $resolver->resolve(FileSystem::read($filePath), $output);

        $output->writeln($day . ' Result for ' . $quest . ' quest: ' . $result);
    }
}
