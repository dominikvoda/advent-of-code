<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Solutions\Day2;

use AdventOfCode\Season2018\Solutions\InputReader;
use AdventOfCode\Season2018\Solutions\ResolverInterface;
use function array_map;
use function str_split;
use function substr_count;
use Symfony\Component\Console\Output\OutputInterface;
use function array_unique;

class FirstPartResolver implements ResolverInterface
{
    public function resolve(string $input, OutputInterface $output): string
    {
        $inputLines = InputReader::readAsLines($input);

        $doubles = 0;
        $triples = 0;

        foreach ($inputLines as $inputLine) {
            $chars = array_unique(str_split($inputLine));
            $doubleCounted = false;
            $tripleCounted = false;

            foreach ($chars as $char) {
                $count = substr_count($inputLine, $char);

                if ($count === 1) {
                    continue;
                }

                if ($count === 2 && !$doubleCounted) {
                    $doubles++;
                    $doubleCounted = true;
                }

                if ($count === 3 && !$tripleCounted) {
                    $triples++;
                    $tripleCounted = true;
                }

                if ($doubleCounted && $tripleCounted) {
                    break;
                }
            }
        }

        return (string)($doubles * $triples);
    }
}
