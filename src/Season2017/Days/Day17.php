<?php

namespace AdventOfCode\Season2017\Days;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class Day17 extends DefaultDay
{
    /**
     * @return string
     */
    protected function getInputType(): string
    {
        return self::INPUT_DIRECT;
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveFirstPuzzle($input): string
    {
        $pointer = 0;
        $numbers = [0];
        for ($i = 1; $i < 2018; $i++) {
            $pointer += $input;
            $pointer %= $i;
            $pointer++;
            $this->arrayInsert($numbers, $i, $pointer);
        }

        return $numbers[$pointer + 1];
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $pointer = 0;
        $numbers = [0];
        $steps = 50000000;

        $progressBar = new ProgressBar(new ConsoleOutput());
        $progressBar->setRedrawFrequency(100000);
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');
        $progressBar->start($steps);

        for ($i = 1; $i <= $steps; $i++) {
            $pointer += $input;
            $pointer %= $i;
            $pointer++;
            if($pointer === 1){
                $numbers[1] = $i;
            }
            $progressBar->advance();
        }

        $progressBar->finish();

        return $numbers[1];
    }

    /**
     * @return string
     */
    protected function getDirectInput(): string
    {
        return 316;
    }

    /**
     * @param array $array
     * @param int   $number
     * @param int   $position
     */
    private function arrayInsert(array &$array, int $number, int $position): void
    {
        array_splice($array, $position, 0, $number);
    }
}
