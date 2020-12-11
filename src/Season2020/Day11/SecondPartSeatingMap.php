<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day11;

use function in_array;

final class SecondPartSeatingMap extends SeatingMap
{
    public function countOccupiedAround(int $y, int $x): int
    {
        $distance = 1;
        $foundSeats = 0;
        $occupied = 0;
        $foundDirections = [];

        while ($foundSeats !== 8) {
            $indexes = $this->getIndexes($y, $x, $distance);

            foreach ($indexes as $direction => $index) {
                if (in_array($direction, $foundDirections, true)) {
                    continue;
                }

                if (!isset($this->seats[$index['y']][$index['x']])) {
                    $foundSeats++;
                    $foundDirections[] = $direction;
                    continue;
                }

                $seat = $this->seats[$index['y']][$index['x']];

                if ($seat === '.') {
                    continue;
                }

                if ($seat === '#') {
                    $occupied++;
                }

                $foundSeats++;
                $foundDirections[] = $direction;
            }

            $distance++;
        }

        return $occupied;
    }
}
