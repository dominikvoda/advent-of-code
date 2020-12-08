<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day8;

final class Accumulator
{
    public function __construct()
    {
        $this->value = 0;
    }


    public function increaseValue(int $increment): void
    {
        $this->value += $increment;
    }


    public function getValue(): int
    {
        return $this->value;
    }
}
