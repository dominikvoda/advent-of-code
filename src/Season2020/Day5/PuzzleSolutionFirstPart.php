<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day5;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_map;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        /** @var Seat[] $seats */
        $seats = LinesInput::createAsObjects(__DIR__ . '/input.txt', Seat::class);

        $seatIds = array_map(
            static function (Seat $seat): int {
                return $seat->getSeatId();
            },
            $seats
        );

        return new IntegerResult(max($seatIds));
    }
}
