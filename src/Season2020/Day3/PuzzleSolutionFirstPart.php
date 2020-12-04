<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day3;

use AdventOfCode\Season2020\GridInput;
use AdventOfCode\Season2020\PuzzleSolution;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): string
    {
        $gridInput = new GridInput(__DIR__ . '/input.txt');

        return (string)TreeCounter::count($gridInput, 3, 1);
    }
}
