<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day8;

use function count;
use function explode;
use function in_array;

final class Game
{
    public static function run(Accumulator $accumulator, array $lines): void
    {
        $maxPointer = count($lines);
        $pointer = 0;

        $executedInstructions = [];

        while (true) {
            $line = $lines[$pointer];

            if (in_array($pointer, $executedInstructions, true)) {
                throw InfiniteLoopException::create();
            }

            $executedInstructions[] = $pointer;

            [$instruction, $argument] = explode(' ', $line);

            if ($instruction === 'nop') {
                $pointer++;
            }

            if ($instruction === 'acc') {
                $accumulator->increaseValue((int)$argument);
                $pointer++;
            }

            if ($instruction === 'jmp') {
                $pointer += (int)$argument;
            }

            if ($pointer >= $maxPointer) {
                return;
            }
        }
    }
}
