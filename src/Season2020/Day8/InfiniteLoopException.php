<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day8;

use Exception;

final class InfiniteLoopException extends Exception
{
    public static function create(): self
    {
        return new self('Infinite loop instructions in game');
    }
}
