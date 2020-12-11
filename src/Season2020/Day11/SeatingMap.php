<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day11;

use function array_filter;
use function array_merge;
use function count;

abstract class SeatingMap
{
    /**
     * @var string[][]
     */
    protected $seats;


    /**
     * @param string[][] $seats
     */
    public function __construct(array $seats)
    {
        $this->seats = $seats;
    }


    abstract public function countOccupiedAround(int $y, int $x): int;


    protected function getIndexes(int $y, int $x, int $distance = 1): array
    {
        return [
            ['y' => $y - $distance, 'x' => $x - $distance],
            ['y' => $y - $distance, 'x' => $x],
            ['y' => $y - $distance, 'x' => $x + $distance],
            ['y' => $y, 'x' => $x - $distance],
            ['y' => $y, 'x' => $x + $distance],
            ['y' => $y + $distance, 'x' => $x - $distance],
            ['y' => $y + $distance, 'x' => $x],
            ['y' => $y + $distance, 'x' => $x + $distance],
        ];
    }


    public function getSeat(int $y, int $x): string
    {
        return $this->seats[$y][$x];
    }


    public function countOccupied(): int
    {
        $occupied = array_filter(
            array_merge(...$this->seats),
            static function (string $seat): bool {
                return $seat === '#';
            }
        );

        return count($occupied);
    }


    public function isSame(SeatingMap $seatingMap): bool
    {
        return $this->seats === $seatingMap->seats;
    }
}
