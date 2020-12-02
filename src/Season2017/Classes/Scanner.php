<?php

namespace AdventOfCode\Season2017\Classes;

class Scanner
{
    private const DOWN = 'down';
    private const UP = 'up';

    /**
     * @var int
     */
    private $column;

    /**
     * @var int
     */
    private $depth;

    /**
     * @var int
     */
    private $pointer;

    private $direction;

    /**
     * @param int $depth
     */
    public function __construct(int $depth, int $column)
    {
        $this->column = $column;
        $this->depth = $depth;
        $this->pointer = 0;
        $this->direction = self::DOWN;
        $this->top = $this->calcTop();
    }

    /**
     *
     */
    public function tick(): void
    {
        if ($this->direction === self::DOWN) {
            $this->pointer++;
        }

        if ($this->direction === self::UP) {
            $this->pointer--;
        }

        if ($this->pointer === -1) {
            $this->pointer = 1;
            $this->direction = self::DOWN;
        }

        if ($this->pointer === $this->depth) {
            $this->pointer = $this->depth - 2;
            $this->direction = self::UP;
        }
    }

    /**
     * @param int $delay
     *
     * @return bool
     */
    public function isCaught(int $delay = 0): bool
    {
        $offset = $delay + $this->column;

        return $offset % $this->top === 0;
    }

    /**
     * @return int
     */
    public function getSeverity(): int
    {
        return $this->column * $this->depth;
    }

    /**
     *
     */
    public function reset(): void
    {
        $this->pointer = 0;
        $this->direction = self::DOWN;
    }

    /**
     * @param int $offset
     *
     * @return int
     */
    private function calcTop(int $offset = 0): int
    {
        $this->tick();
        if ($this->pointer === 0) {
            return $offset + 1;
        }

        return $this->calcTop($offset + 1);
    }

    /**
     * @return int
     */
    public function getTop(): int
    {
        return $this->top;
    }

    /**
     * @return int
     */
    public function getColumn(): int
    {
        return $this->column;
    }
}
