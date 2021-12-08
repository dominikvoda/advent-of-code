<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day6;

use function count;
use function usort;

final class Grid
{
    /**
     * @var Coordinate[]
     */
    private $coordinates;

    /**
     * @var int[][]
     */
    private $points;


    public function __construct(array $coordinates)
    {
        $this->coordinates = $coordinates;
        $byXValue = $coordinates;
        $byYValue = $coordinates;

        usort($byXValue, [Coordinate::class, 'compareByX']);
        usort($byYValue, [Coordinate::class, 'compareByY']);

        $total = count($coordinates);
        $left = $byXValue[0];
        $right = $byXValue[$total - 1];
        $top = $byYValue[0];
        $bottom = $byYValue[$total - 1];

        $this->points = [];

        for ($y = $top->getY(); $y < $bottom->getY(); $y++) {
            for ($x = $left->getX(); $x < $right->getX(); $x++) {
                $this->points[] = ['y' => $y, 'x' => $x];
            }
        }
    }


    public function getAllPoints(): array
    {
        return $this->points;
    }


    public function getClosestCoordinate(int $y, int $x): ?Coordinate
    {
        $distance = PHP_INT_MAX;
        $closestCoordinates = [];

        foreach ($this->coordinates as $coordinate) {
            $currentDistance = $coordinate->getDistance($y, $x);

            if ($currentDistance === 0) {
                return $coordinate;
            }

            if ($currentDistance > $distance) {
                continue;
            }

            if ($currentDistance === $distance) {
                $closestCoordinates[] = $coordinate;
            }

            if ($currentDistance < $distance) {
                $closestCoordinates = [$coordinate];
                $distance = $currentDistance;
            }
        }

        if (count($closestCoordinates) === 1) {
            return $closestCoordinates[0];
        }

        return null;
    }
}
