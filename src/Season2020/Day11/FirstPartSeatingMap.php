<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day11;

final class FirstPartSeatingMap extends SeatingMap
{
    public function countOccupiedAround(int $y, int $x): int
    {
        $indexes = $this->getIndexes($y, $x);

        $occupied = 0;

        foreach ($indexes as $index) {
            $seat = $this->seats[$index['y']][$index['x']] ?? '.';

            if ($seat === '#') {
                $occupied++;
            }
        }

        return $occupied;
    }
}
