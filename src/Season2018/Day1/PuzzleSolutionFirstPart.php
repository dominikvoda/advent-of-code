<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day1;

use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use function array_sum;

class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): string
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        return (string)array_sum($input->getLines());
    }
}
