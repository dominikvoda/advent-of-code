<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day12;

use function abs;
use function in_array;

final class Ship
{
    /**
     * @var int
     */
    private $east;

    /**
     * @var int
     */
    private $north;

    /**
     * @var int
     */
    private $directionX;

    /**
     * @var int
     */
    private $directionY;


    public function __construct()
    {
        $this->east = 0;
        $this->north = 0;
        $this->directionX = 1;
        $this->directionY = 0;
    }


    public function move(string $command, int $distance): void
    {
        if ($command === 'F') {
            $this->forward($distance);

            return;
        }

        if (in_array($command, ['L', 'R'], true)) {
            $this->rotate($command, $distance);

            return;
        }

        $this->moveInDirection($command, $distance);
    }


    public function moveToWaypoint(Waypoint $waypoint, int $distance): void
    {
        $this->east += $distance * $waypoint->getEast();
        $this->north += $distance * $waypoint->getNorth();
    }


    public function getDistance(): int
    {
        return abs($this->east) + abs($this->north);
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


    private function rotate(string $direction, int $degrees): void
    {
        $rotations = $degrees / 90;

        for ($i = 0; $i < $rotations; $i++) {
            if ($direction === 'R') {
                $newDirectionX = $this->directionY;
                $newDirectionY = -$this->directionX;
                $this->directionX = $newDirectionX;
                $this->directionY = $newDirectionY;
            }

            if ($direction === 'L') {
                $newDirectionX = -$this->directionY;
                $newDirectionY = $this->directionX;
                $this->directionX = $newDirectionX;
                $this->directionY = $newDirectionY;
            }
        }
    }


    private function forward(int $distance): void
    {
        $this->east += $distance * $this->directionX;
        $this->north += $distance * $this->directionY;
    }
}
