<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day2;

use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use function array_unique;
use function str_split;
use function substr_count;

class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): string
    {
        $input = new LinesInput(__DIR__ . '/input.txt');
        $doubles = 0;
        $triples = 0;

        foreach ($input->getLines() as $inputLine) {
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
