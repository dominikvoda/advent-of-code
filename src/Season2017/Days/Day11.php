<?php

namespace AdventOfCode\Season2017\Days;

class Day11 extends DefaultDay
{
    /**
     * @var array
     */
    private static $directionsMap = [
        'n'  => [0, 1],
        'ne' => [0.5, 0.5],
        'e'  => [1, 0],
        'se' => [0.5, -0.5],
        's'  => [0, -1],
        'sw' => [-0.5, -0.5],
        'w'  => [-1, 0],
        'nw' => [-0.5, 0.5],
    ];

    private static $oppositesMap = [
        'n'  => 's',
        's'  => 'n',
        'ne' => 'sw',
        'sw' => 'ne',
        'nw' => 'se',
        'se' => 'nw',
        'e'  => 'w',
        'w'  => 'e',
    ];

    /**
     * @return string
     */
    protected function getInputType(): string
    {
        return self::INPUT_SIMPLE;
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveFirstPuzzle($input): string
    {
        $directions = $this->loadDirections($input);
        $start = [0, 0];
        foreach ($directions as $direction) {
            $start[0] += $direction[0];
            $start[1] += $direction[1];
        }

        return $this->calcSteps($start[0], $start[1]);
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $furthestDistance = 0;
        $furthest = [0, 0];
        $directions = $this->loadDirections($input);
        $start = [0, 0];
        foreach ($directions as $direction) {
            $start[0] += $direction[0];
            $start[1] += $direction[1];

            $absoluteDistance = $this->calcAbsoluteDistance($start[0], $start[1]);
            if ($absoluteDistance > $furthestDistance) {
                $furthestDistance = $absoluteDistance;
                $furthest = [$start[0], $start[1]];
            }
        }

        return $this->calcSteps($furthest[0], $furthest[1]);
    }

    private function calcAbsoluteDistance(float $x, float $y): float
    {
        return abs($x) + abs($y);
    }

    /**
     * @param string $input
     *
     * @return array
     */
    private function loadDirections(string $input): array
    {
        $rawDirections = explode(',', $input);
        $directions = [];

        foreach ($rawDirections as $direction) {
            $directions[] = self::$directionsMap[$direction];
        }

        return $directions;
    }

    /**
     * @param float $x
     * @param float $y
     *
     * @return int
     */
    private function calcSteps(float $x, float $y): int
    {
        $steps = 0;
        while (!($x == 0 && $y == 0)) {
            $steps++;
            $horizontal = $this->getHorizontal($x);
            $vertical = $this->getVertical($y);
            $oppositeDirection = $this->getOpposite($vertical . $horizontal);

            echo sprintf('%s [%s, %s] - %s', $steps, $x, $y, $oppositeDirection);
            echo PHP_EOL;

            $direction = self::$directionsMap[$oppositeDirection];
            $x += $direction[0];
            $y += $direction[1];
        }

        return $steps;
    }

    /**
     * @param float $y
     *
     * @return string
     */
    private function getVertical(float $y): string
    {
        if ($y > 0) {
            $vertical = 'n';
        } else {
            $vertical = 's';
        }

        if ($y == 0) {
            $vertical = '';
        }

        return $vertical;
    }

    /**
     * @param $x
     *
     * @return string
     */
    private function getHorizontal($x): string
    {
        if ($x > 0) {
            $horizontal = 'e';
        } else {
            $horizontal = 'w';
        }

        if ($x == 0) {
            $horizontal = '';
        }

        return $horizontal;
    }

    /**
     * @param string $direction
     *
     * @return string
     */
    private function getOpposite(string $direction): string
    {
        return self::$oppositesMap[$direction];
    }
}
