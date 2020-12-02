<?php

namespace AdventOfCode\Season2017\Days;

use AdventOfCode\Season2017\Classes\ExperimentalCoprocessor;

class Day23 extends DefaultDay
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
        $experimentalCoprocessor = new ExperimentalCoprocessor($input);
        $experimentalCoprocessor->run();

        return $experimentalCoprocessor->getMulCounter();
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $experimentalCoprocessor = new ExperimentalCoprocessor($input);
        $experimentalCoprocessor->set('a', 1);
        $experimentalCoprocessor->run();

        return $experimentalCoprocessor->getRegisterValue('h');
    }
}
