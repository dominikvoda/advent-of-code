<?php

namespace AdventOfCode\Season2017\Days;

use AdventOfCode\Season2017\Classes\Program;
use AdventOfCode\Season2017\Classes\Tower;

class Day7 extends DefaultDay
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
        $tower = new Tower();
        /** @var string $row */
        foreach ($input as $row) {
            $program = new Program($row);
            $tower->registerProgram($program);
        }

        return $tower->getRoot();
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $tower = new Tower();
        /** @var string $row */
        foreach ($input as $row) {
            $program = new Program($row);
            $tower->registerProgram($program);
        }

        return $tower->getInvalidWeight();
    }
}
