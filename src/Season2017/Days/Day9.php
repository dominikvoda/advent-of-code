<?php

namespace AdventOfCode\Season2017\Days;

class Day9 extends DefaultDay
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
        $length = strlen($input);
        $garbage = false;
        $depth = 1;
        $total = 0;
        for ($i = 0; $i < $length; $i++) {
            $char = $input[$i];
            if ($char === '!') {
                $i++;
            } elseif (!$garbage && $char === '<') {
                $garbage = true;
            } elseif ($char === '>') {
                $garbage = false;
            } elseif (!$garbage && $char === '{') {
                $total += $depth++;
            } elseif (!$garbage && $char === '}') {
                $depth--;
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
        $garbage = false;
        $total = 0;
        for ($i = 0; $i < $length; $i++) {
            $char = $input[$i];
            if ($char === '!') {
                $i++;
            } elseif ($garbage && $char !== '>') {
                $total++;
            } elseif ($char === '<') {
                $garbage = true;
            } elseif ($char === '>') {
                $garbage = false;
            }
        }

        return $total;
    }
}
