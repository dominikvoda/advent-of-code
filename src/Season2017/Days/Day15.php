<?php

namespace AdventOfCode\Season2017\Days;

use AdventOfCode\Season2017\Classes\Generator;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class Day15 extends DefaultDay
{
    private const MAX_A = 40000000;
    private const MAX_B = 5000000;

    /**
     * @return string
     */
    protected function getInputType(): string
    {
        return self::INPUT_NONE;
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveFirstPuzzle($input): string
    {
        $generatorA = new Generator(722, 16807);
        $generatorB = new Generator(354, 48271);
        $total = 0;

        $progressBar = new ProgressBar(new ConsoleOutput());
        $progressBar->start(self::MAX_A);
        $progressBar->setRedrawFrequency(10000);
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');

        for ($i = 0; $i < self::MAX_A; $i++) {
            $binaryA = $generatorA->getNextBinaryString();
            $binaryB = $generatorB->getNextBinaryString();

            if ($binaryA === $binaryB) {
                $total++;
            }
            $progressBar->advance();
        }

        $progressBar->finish();

        return $total;
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $generatorA = new Generator(722, 16807);
        $generatorB = new Generator(354, 48271);
        $total = 0;

        $progressBar = new ProgressBar(new ConsoleOutput());
        $progressBar->start(self::MAX_B);
        $progressBar->setRedrawFrequency(100);
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');

        for ($i = 0; $i < self::MAX_B; $i++) {
            $binaryA = $generatorA->getNextBinaryString(4);
            $binaryB = $generatorB->getNextBinaryString(8);

            if ($binaryA === $binaryB) {
                $total++;
            }
            $progressBar->advance();
        }

        $progressBar->finish();

        return $total;
    }
}
