<?php

namespace AdventOfCode\Season2017\Days;

use AdventOfCode\Season2017\Classes\Village;

class Day12 extends DefaultDay
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
        $village = new Village();
        /** @var string $line */
        foreach ($input as $line) {
            $village->addProgram($line);
        }

        $zeroProgram = $village->getProgram(0);
        $zeroProgram->traceConnections($village);

        return $village->countVisitedPrograms();
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $village = new Village();
        /** @var string $line */
        foreach ($input as $line) {
            $village->addProgram($line);
        }

        $rootProgram = $village->getNextUnvisitedProgram();
        $total = 0;

        while (null !== $rootProgram) {
            $rootProgram->traceConnections($village);
            $total++;
            $rootProgram = $village->getNextUnvisitedProgram();
        }

        return $total;
    }
}
