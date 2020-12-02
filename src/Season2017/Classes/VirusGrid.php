<?php

namespace AdventOfCode\Season2017\Classes;

class VirusGrid
{
    private const UP = 'up';
    private const DOWN = 'down';
    private const LEFT = 'left';
    private const RIGHT = 'right';

    /**
     * @var array
     */
    private static $directionCircle = [
        0 => self::UP,
        1 => self::RIGHT,
        2 => self::DOWN,
        3 => self::LEFT,
    ];

    /**
     * @var int
     */
    private $maxX;

    /**
     * @var int
     */
    private $maxY;

    /**
     * @var array
     */
    private $grid;

    /**
     * @var int
     */
    private $infectedCounter;

    /**
     * @param array $input
     */
    public function __construct(array $input)
    {
        $this->grid = [];
        $this->loadGrid($input);
        $this->virusPosition = $this->getVirusPosition();
        $this->direction = self::UP;
        $this->directionKey = 0;
        $this->infectedCounter = 0;
    }

    /**
     * @param int $part
     */
    public function tick(int $part = 1): void
    {
        $key = $this->virusPosition;
        if ($part === 1) {
            if ($this->isInfected($key)) {
                $this->turnRight();
                $this->clean($key);
            } else {
                if ($this->isClean($key)) {
                    $this->turnLeft();
                    $this->infect($key);
                }
            }
        }

        if ($part === 2) {
            if ($this->isInfected($key)) {
                $this->turnRight();
                $this->grid[$key] = 'F';
            } else {
                if ($this->isClean($key)) {
                    $this->turnLeft();
                    $this->grid[$key] = 'W';
                } else {
                    if ($this->isWeakened($key)) {
                        $this->infect($key);
                    } else {
                        if ($this->isFlagged($key)) {
                            $this->turnLeft();
                            $this->turnLeft();
                            $this->clean($key);
                        }
                    }
                }
            }
        }

        $this->move();
    }

    /**
     * @param array $input
     *
     * @return array
     */
    private function loadGrid(array $input)
    {
        $y = 0;
        /** @var string $row */
        foreach ($input as $row) {
            $x = 0;
            /** @var  $str */
            foreach (str_split($row) as $char) {
                $this->createIfNotExist($x, $y, $char);
                $x++;
            }
            $y++;
        }
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    private function isInfected(string $key): bool
    {
        return $this->grid[$key] === '#';
    }

    /**
     * @param string $key
     */
    private function clean(string $key): void
    {
        $this->grid[$key] = '.';
    }

    /**
     * @param string $key
     */
    private function infect(string $key): void
    {
        $this->infectedCounter++;
        $this->grid[$key] = '#';
    }

    /**
     * @param int $x
     * @param int $y
     *
     * @return string
     */
    private function getKey(int $x, int $y): string
    {
        return sprintf('%d_%d', $x, $y);
    }

    /**
     * @param string $key
     *
     * @return array
     */
    private function getCoordinates(string $key): array
    {
        $parts = explode('_', $key);

        return [
            'x' => $parts[0],
            'y' => $parts[1],
        ];
    }

    /**
     * @param int    $x
     * @param int    $y
     * @param string $char
     *
     * @return string
     */
    private function createIfNotExist(int $x, int $y, string $char = '.'): string
    {
        $key = $this->getKey($x, $y);
        if (!array_key_exists($key, $this->grid)) {
            $this->grid[$key] = $char;
            $this->updateMaxX($x);
            $this->updateMaxY($y);
        }

        return $key;
    }

    /**
     * @param int $x
     */
    private function updateMaxX(int $x): void
    {
        if ($x > $this->maxX) {
            $this->maxX = $x;
        }
    }

    /**
     * @param int $y
     */
    private function updateMaxY(int $y): void
    {
        if ($y > $this->maxY) {
            $this->maxY = $y;
        }
    }

    /**
     * @return string
     */
    private function getVirusPosition(): string
    {
        $x = ceil($this->maxX / 2);
        $y = ceil($this->maxY / 2);

        return $this->getKey($x, $y);
    }

    private function turnRight(): void
    {
        $this->directionKey++;
        if ($this->directionKey > 3) {
            $this->directionKey = 0;
        }
        $this->direction = self::$directionCircle[$this->directionKey];
    }

    private function turnLeft(): void
    {
        $this->directionKey--;
        if ($this->directionKey < 0) {
            $this->directionKey = 3;
        }
        $this->direction = self::$directionCircle[$this->directionKey];
    }

    private function move(): void
    {
        $coordinates = $this->getCoordinates($this->virusPosition);
        $x = $coordinates['x'];
        $y = $coordinates['y'];

        if ($this->direction === self::UP) {
            $y--;
        }

        if ($this->direction === self::DOWN) {
            $y++;
        }

        if ($this->direction === self::LEFT) {
            $x--;
        }

        if ($this->direction === self::RIGHT) {
            $x++;
        }

        $this->virusPosition = $this->createIfNotExist($x, $y, '.');
    }

    /**
     * @return int
     */
    public function getInfectedCounter(): int
    {
        return $this->infectedCounter;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    private function isClean(string $key): bool
    {
        return $this->grid[$key] === '.';
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    private function isFlagged(string $key)
    {
        return $this->grid[$key] === 'F';
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    private function isWeakened(string $key)
    {
        return $this->grid[$key] === 'W';
    }
}
