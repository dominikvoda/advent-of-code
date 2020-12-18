<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day15;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    private const STARTING_NUMBERS = '0,5,4,1,10,14,7';


    public function getResult(): Result
    {
        $game = new MemoryGame(2020);

        return new IntegerResult($game->play(self::STARTING_NUMBERS));
    }
}
