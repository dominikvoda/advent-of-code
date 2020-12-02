<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Day1;

use AdventOfCode\Season2019\Input;
use AdventOfCode\Season2019\PuzzleInterface;
use function array_sum;
use function floor;

class Puzzle implements PuzzleInterface
{
    public function resolveFirstPart(): string
    {
        $input = Input::linesFromFile(__DIR__ . '/input.txt');

        $fuelNeeded = $input->map(
            static function (string $value): int {
                $divide = (int)floor((int)$value / 3);

                return $divide - 2;
            }
        );

        return (string)array_sum($fuelNeeded->toArray());
    }


    public function resolveSecondPart(): string
    {
        $input = Input::linesFromFile(__DIR__ . '/input.txt');

        $fuelNeeded = $input->map(
            function (string $value): int {
                return $this->getFuel((int)$value);
            }
        );

        return (string)array_sum($fuelNeeded->toArray());
    }


    private function getFuel(int $mass): int
    {
        $fuel = (int)floor($mass / 3) - 2;

        if ($fuel <= 0) {
            return 0;
        }

        return $fuel + $this->getFuel($fuel);
    }
}
