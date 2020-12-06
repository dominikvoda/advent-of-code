<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day3;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use AdventOfCode\Season2020\GridInput;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $gridInput = new GridInput(__DIR__ . '/input.txt');

        return new IntegerResult(TreeCounter::count($gridInput, 3, 1));
    }
}
