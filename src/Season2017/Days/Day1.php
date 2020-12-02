<?php

namespace AdventOfCode\Season2017\Days;

class Day1 extends DefaultDay
{
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
        $total = 0;
        $circle = $input . $input;
        $length = strlen($input);
        for ($i = 0; $i <= $length; $i++) {
            if ($circle[$i] === $circle[$i + 1]) {
                $total += $input[$i];
            }
        }

        return $total;
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $length = strlen($input);
        $total = 0;
        $offset = $length / 2;
        $circle = $input . $input;
        for ($i = 0; $i <= $length; $i++) {
            if ($circle[$i + $offset] === $circle[$i]) {
                $total += $circle[$i + $offset];
            }
        }

        return $total;
    }
}
