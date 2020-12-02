<?php

namespace AdventOfCode\Season2017\Days;

use InvalidArgumentException;

class Day19 extends DefaultDay
{
    private const DOWN = 'down';
    private const UP = 'top';
    private const LEFT = 'left';
    private const RIGHT = 'right';

    /**
     * @return string
     */
    protected function getInputType(): string
    {
        return self::INPUT_LINES;
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveFirstPuzzle($input): string
    {
        $map = $this->loadMap($input);
        $currentCoordinates = $this->findStart($map[0]);
        $direction = self::DOWN;
        $result = [];

        while (true) {
            $currentCoordinates = $this->getNextCoordinates($currentCoordinates, $direction);
            $nextChar = $map[$currentCoordinates[1]][$currentCoordinates[0]];

            if ($nextChar === ' ') {
                break;
            }

            if ($nextChar === '+') {
                $direction = $this->getNextDirection($direction, $map, $currentCoordinates);
                continue;
            }

            if ($nextChar !== '|' && $nextChar !== '-') {
                $result[] = $nextChar;
            }
        }

        return join('', $result);
    }

    protected function resolveSecondPuzzle($input): string
    {
        $map = $this->loadMap($input);
        $currentCoordinates = $this->findStart($map[0]);
        $direction = self::DOWN;
        $result = [];
        $total = 1;

        while (true) {
            $currentCoordinates = $this->getNextCoordinates($currentCoordinates, $direction);
            $nextChar = $map[$currentCoordinates[1]][$currentCoordinates[0]];

            if ($nextChar === ' ') {
                break;
            }

            if ($nextChar === '+') {
                $direction = $this->getNextDirection($direction, $map, $currentCoordinates);
                $total++;
                continue;
            }

            if ($nextChar !== '|' && $nextChar !== '-') {
                $result[] = $nextChar;
            }
            $total++;
        }

        return $total;
    }

    /**
     * @param array $firstLine
     *
     * @return array
     */
    private function findStart(array $firstLine)
    {
        return [array_search('|', $firstLine), 0];
    }

    /**
     * @param array  $currentCoordinates
     * @param string $direction
     *
     * @return array
     */
    private function getNextCoordinates(array $currentCoordinates, string $direction): array
    {
        $x = $currentCoordinates[0];
        $y = $currentCoordinates[1];
        if ($direction === self::DOWN) {
            return [$x, $y + 1];
        }
        if ($direction === self::UP) {
            return [$x, $y - 1];
        }
        if ($direction === self::LEFT) {
            return [$x - 1, $y];
        }
        if ($direction === self::RIGHT) {
            return [$x + 1, $y];
        }

        throw new InvalidArgumentException('Invalid input');
    }

    /**
     * @param array $input
     * @param array $currentCoordinates
     *
     * @return string
     */
    private function getNextDirection(string $direction, array $input, array $currentCoordinates): string
    {
        $x = $currentCoordinates[0];
        $y = $currentCoordinates[1];

        if (isset($input[$y][$x + 1]) && $input[$y][$x + 1] !== ' ' && $direction !== self::LEFT) {
            return self::RIGHT;
        }
        if (isset($input[$y][$x - 1]) && $input[$y][$x - 1] !== ' ' && $direction !== self::RIGHT) {
            return self::LEFT;
        }
        if (isset($input[$y + 1][$x]) && $input[$y + 1][$x] !== ' ' && $direction !== self::UP) {
            return self::DOWN;
        }
        if (isset($input[$y - 1][$x]) && $input[$y - 1][$x] !== ' ' && $direction !== self::DOWN) {
            return self::UP;
        }

        throw new InvalidArgumentException('Invalid input');
    }

    /**
     * @param array $input
     *
     * @return array
     */
    private function loadMap(array $input): array
    {
        $map = [];
        /** @var string $row */
        foreach ($input as $row) {
            $map[] = str_split($row);
        }

        return $map;
    }
}
