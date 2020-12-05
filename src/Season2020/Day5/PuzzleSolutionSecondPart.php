<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day5;

use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use LogicException;
use function array_map;
use function sort;

final class PuzzleSolutionSecondPart implements PuzzleSolution
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

        sort($seatIds);

        foreach ($seatIds as $index => $seatId) {
            if($seatIds[$index + 1] !== $seatId + 1){
                return (string)++$seatId;
            }
        }

        throw new LogicException('Oh no!');
    }
}
