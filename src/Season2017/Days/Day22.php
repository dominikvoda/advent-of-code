<?php

namespace AdventOfCode\Season2017\Days;

use AdventOfCode\Season2017\Classes\VirusGrid;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class Day22 extends DefaultDay
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
        $virusGrid = new VirusGrid($input);
        for ($i = 0; $i < 10000; $i++) {
            $virusGrid->tick();
        }

        return $virusGrid->getInfectedCounter();
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $iterations = 10000000;
        $virusGrid = new VirusGrid($input);

        $progressBar = new ProgressBar(new ConsoleOutput());
        $progressBar->setRedrawFrequency(1000);
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');
        $progressBar->start($iterations);

        for ($i = 0; $i < $iterations; $i++) {
            $virusGrid->tick(2);
            $progressBar->advance();
        }
        $progressBar->finish();

        return $virusGrid->getInfectedCounter();
    }
}
