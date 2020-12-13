<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day12;

use function in_array;

final class Waypoint
{
    /**
     * @var int
     */
    private $north;

    /**
     * @var int
     */
    private $east;


    public function __construct()
    {
        $this->north = 1;
        $this->east = 10;
    }


    public function move(string $command, int $distance): void
    {
        if (in_array($command, ['L', 'R'], true)) {
            $this->rotate($command, $distance);

            return;
        }

        $this->moveInDirection($command, $distance);
    }


    private function rotate(string $direction, int $degrees): void
    {
        $rotations = $degrees / 90;

        for ($i = 0; $i < $rotations; $i++) {
            if ($direction === 'R') {
                $newNorth = -$this->east;
                $newEast = $this->north;
                $this->north = $newNorth;
                $this->east = $newEast;
            }

            if ($direction === 'L') {
                $nowNorth = $this->east;
                $newEast = -$this->north;
                $this->north = $nowNorth;
                $this->east = $newEast;
            }
        }
    }


    private function moveInDirection(string $direction, int $distance): void
    {
        $nextPositions = [
            'N' => ['east' => 0, 'north' => $distance],
            'S' => ['east' => 0, 'north' => -$distance],
            'E' => ['east' => $distance, 'north' => 0],
            'W' => ['east' => -$distance, 'north' => 0],
        ];

        $this->east += $nextPositions[$direction]['east'];
        $this->north += $nextPositions[$direction]['north'];
    }


    public function getNorth(): int
    {
        return $this->north;
    }


    public function getEast(): int
    {
        return $this->east;
    }
}
