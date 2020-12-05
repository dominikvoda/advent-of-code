<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day3;

use AdventOfCode\PuzzleSolution;
use AdventOfCode\Season2020\GridInput;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): string
    {
        $gridInput = new GridInput(__DIR__ . '/input.txt');

        $strategies = [
            ['x' => 1, 'y' => 1],
            ['x' => 3, 'y' => 1],
            ['x' => 5, 'y' => 1],
            ['x' => 7, 'y' => 1],
            ['x' => 1, 'y' => 2],
        ];

        $sum = 1;

        foreach ($strategies as $strategy) {
            $sum *= TreeCounter::count($gridInput, $strategy['x'], $strategy['y']);
        }

        return (string)$sum;
    }
}
