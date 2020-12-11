<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day11;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $seatingMapFinder = new SeatingMapFinder(FirstPartSeatingMap::class, 4);

        $seatingMap = $seatingMapFinder->findFinalSeatingMap(__DIR__ . '/input.txt');

        return new IntegerResult($seatingMap->countOccupied());
    }
}
