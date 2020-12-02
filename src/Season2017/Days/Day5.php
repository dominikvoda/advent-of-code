<?php

namespace AdventOfCode\Season2017\Days;

class Day5 extends DefaultDay
{
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
        $size = count($input);
        $i = 0;
        $instructions = $input;
        $pointer = 0;
        while (true) {
            if ($pointer >= $size) {
                break;
            }
            $offset = $instructions[$pointer];
            $instructions[$pointer]++;
            $pointer += $offset;
            $i++;
        }

        return $i;
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $size = count($input);
        $i = 0;
        $instructions = $input;
        $pointer = 0;
        while (true) {
            if ($pointer >= $size) {
                break;
            }
            $offset = $instructions[$pointer];
            if ($offset >= 3) {
                $instructions[$pointer]--;
            } else {
                $instructions[$pointer]++;
            }
            $pointer += $offset;
            $i++;
        }

        return $i;
    }
}
