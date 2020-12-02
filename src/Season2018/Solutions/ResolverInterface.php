<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Solutions;

use Symfony\Component\Console\Output\OutputInterface;

interface ResolverInterface
{
    public function resolve(string $input, OutputInterface $output): string;
}
