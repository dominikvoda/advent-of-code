<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day1;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        return IntegerResult::fromArraySum($input->getLines());
    }
}
