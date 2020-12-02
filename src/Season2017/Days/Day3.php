<?php

namespace AdventOfCode\Season2017\Days;

use Exception;

class Day3 extends DefaultDay
{
    /**
     * @return string
     */
    protected function getInputType(): string
    {
        return self::INPUT_DIRECT;
    }

    /**
     * @return string
     */
    protected function getDirectInput(): string
    {
        return '347991';
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     * @throws Exception
     */
    protected function resolveFirstPuzzle($input): string
    {
        $grid = [];
        $i = 2;
        $grid['0_0'] = 1;
        $direction = 'right';
        $size = 1;
        $coordinates = ['x' => 0, 'y' => 0];
        while ($i <= $input) {
            $previousCoordinates = $coordinates;
            $direction = $this->getNextDirection($direction, $coordinates, $size);
            $coordinates = $this->getNextCoordinates($direction, $coordinates);
            $coordinatesKey = $this->createCoordinatesKey($coordinates);

            if (array_key_exists($coordinatesKey, $grid)) {
                $direction = 'right';
                $size++;
                $coordinates = $previousCoordinates;
                continue;
            } else {
                $grid[$coordinatesKey] = $i;
            }

            $i++;
        }

        $this->printArray($grid);

        return abs($coordinates['x']) + abs($coordinates['y']);
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     * @throws Exception
     */
    protected function resolveSecondPuzzle($input): string
    {
        $grid = [];
        $i = 0;
        $grid['0_0'] = 1;
        $direction = 'right';
        $size = 1;
        $coordinates = ['x' => 0, 'y' => 0];
        while ($i <= $input) {
            $previousCoordinates = $coordinates;
            $direction = $this->getNextDirection($direction, $coordinates, $size);
            $coordinates = $this->getNextCoordinates($direction, $coordinates);
            $coordinatesKey = $this->createCoordinatesKey($coordinates);

            if (array_key_exists($coordinatesKey, $grid)) {
                $direction = 'right';
                $size++;
                $coordinates = $previousCoordinates;
                continue;
            } else {
                $i = $this->getNextNumber($coordinates, $grid);
                $grid[$coordinatesKey] = $i;
            }
        }

        $this->printArray($grid);

        return $i;
    }

    /**
     * @param string $currentDirection
     * @param array  $coordinates
     * @param int    $size
     *
     * @return string
     */
    private function getNextDirection(string $currentDirection, array $coordinates, int $size): string
    {
        $x = $coordinates['x'];
        $y = $coordinates['y'];

        if ($currentDirection === 'right') {
            if (abs($x) === $size) {
                return 'top';
            }
        }

        if ($currentDirection === 'top') {
            if (abs($y) === $size) {
                return 'left';
            }
        }

        if ($currentDirection === 'left') {
            if (abs($x) === $size) {
                return 'bottom';
            }
        }

        if ($currentDirection === 'bottom') {
            if (abs($y) === $size) {
                return 'right';
            }
        }

        return $currentDirection;
    }

    /**
     * @param string $direction
     * @param array  $currentCoordinates
     *
     * @return string
     * @throws Exception
     */
    private function getNextCoordinates(string $direction, array $currentCoordinates): array
    {
        $x = $currentCoordinates['x'];
        $y = $currentCoordinates['y'];

        if ($direction === 'right') {
            return ['x' => $x + 1, 'y' => $y];
        }

        if ($direction === 'top') {
            return ['x' => $x, 'y' => $y + 1];
        }

        if ($direction === 'left') {
            return ['x' => $x - 1, 'y' => $y];
        }

        if ($direction === 'bottom') {
            return ['x' => $x, 'y' => $y - 1];
        }

        throw new Exception('Invalid direction');
    }

    /**
     * @param array $coordinates
     *
     * @return string
     */
    private function createCoordinatesKey(array $coordinates): string
    {
        return sprintf('%d_%d', $coordinates['x'], $coordinates['y']);
    }

    /**
     * @param array $grid
     */
    private function printArray(array $grid): void
    {
        foreach ($grid as $key => $value) {
            echo sprintf('%s => %s', $key, $value);
            echo PHP_EOL;
        }
    }

    /**
     * @param array $coordinates
     * @param array $grid
     *
     * @return int
     */
    private function getNextNumber(array $coordinates, array $grid): int
    {
        $neighbors = $this->getCoordinatesNeighbors($coordinates);
        $total = 0;
        foreach ($neighbors as $neighborCoordinatesKey) {
            if (array_key_exists($neighborCoordinatesKey, $grid)) {
                $total += $grid[$neighborCoordinatesKey];
            }
        }

        return $total;
    }

    /**
     * @param array $coordinates
     *
     * @return array
     */
    private function getCoordinatesNeighbors(array $coordinates): array
    {
        $neighborCoordinates = [];
        for ($i = -1; $i < 2; $i++) {
            for ($j = -1; $j < 2; $j++) {
                if ($i == 0 && $j == 0) {
                    continue;
                }
                $neighborCoordinates[] = $this->createCoordinatesKey(
                    [
                        'x' => $coordinates['x'] + $i,
                        'y' => $coordinates['y'] + $j,
                    ]
                );
            }
        }

        return $neighborCoordinates;
    }
}
