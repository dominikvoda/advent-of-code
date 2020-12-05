<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day5;

use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use function array_map;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): string
    {
        /** @var Seat[] $seats */
        $seats = LinesInput::createAsObjects(__DIR__ . '/input.txt', Seat::class);

        $seatIds = array_map(
            static function (Seat $seat): int {
                return $seat->getSeatId();
            },
            $seats
        );

        return (string)max($seatIds);
    }
}
