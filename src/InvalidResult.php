<?php declare(strict_types = 1);

namespace AdventOfCode;

final class InvalidResult implements Result
{
    public function toString(): string
    {
        return 'Invalid result, try again noob!';
    }
}
