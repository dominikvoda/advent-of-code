<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Solutions\Day1;

use AdventOfCode\Season2018\Solutions\InputReader;
use AdventOfCode\Season2018\Solutions\ResolverInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FirstPartResolver implements ResolverInterface
{
    public function resolve(string $input, OutputInterface $output): string
    {
        $frequency = 0;

        foreach (InputReader::readAsLines($input) as $change) {
            $frequency += (int)$change;
        }

        return (string)$frequency;
    }
}
