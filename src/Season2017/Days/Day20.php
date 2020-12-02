<?php

namespace AdventOfCode\Season2017\Days;

use AdventOfCode\Season2017\Classes\Particle;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class Day20 extends DefaultDay
{
    const TICKS = 1000;

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
        $i = 0;
        /** @var Particle[] $particles */
        $particles = [];
        /** @var string $row */
        foreach ($input as $row) {
            $particles[$i] = new Particle($row);
            $i++;
        }

        $progressBar = new ProgressBar(new ConsoleOutput());
        $progressBar->setRedrawFrequency(10);
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');
        $progressBar->start(self::TICKS);

        for ($i = 0; $i < self::TICKS; $i++) {
            $this->tick($particles);
            $progressBar->advance();
        }

        $progressBar->finish();

        $min = abs($particles[0]->getAvgDistance());
        $minParticle = 0;

        foreach ($particles as $index => $particle) {
            if (!$particle->isActive()) {
                continue;
            }
            $distance = abs($particle->getAvgDistance());
            if ($distance < $min) {
                $min = $distance;
                $minParticle = $index;
            }
        }

        return $minParticle;
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $i = 0;
        /** @var Particle[] $particles */
        $particles = [];
        /** @var string $row */
        foreach ($input as $row) {
            $particles[$i] = new Particle($row);
            $i++;
        }

        $progressBar = new ProgressBar(new ConsoleOutput());
        $progressBar->setRedrawFrequency(1);
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');
        $progressBar->start(self::TICKS);

        for ($i = 0; $i < self::TICKS; $i++) {
            $this->tick($particles);

            /** @var Particle $particle */
            foreach ($particles as $index => $particle) {
                $this->resolveCollisions($particles);
            }

            $progressBar->advance();

            echo count($particles) . PHP_EOL;
        }

        $progressBar->finish();

        $total = 0;
        /** @var Particle $particle */
        foreach ($particles as $particle) {
            if ($particle->isOk()) {
                $total++;
            }
        }

        return $total;
    }

    /**
     * @param array $particles
     */
    private function resolveCollisions(array &$particles): void
    {
        $positions = [];
        /** @var Particle $particle */
        foreach ($particles as $index => $particle) {
            $positions[$particle->getPositionStamp()][] = $index;
        }

        /** @var array $particleIndexes */
        foreach ($positions as $particleIndexes) {
            if (count($particleIndexes) > 1) {
                /** @var  $particleIndex */
                foreach ($particleIndexes as $particleIndex) {
                    unset($particles[$particleIndex]);
                }
            }
        }
    }

    /**
     * @param array $particles
     */
    private function tick(array $particles): void
    {
        /** @var Particle $particle */
        foreach ($particles as $particle) {
            $particle->tick();
        }
    }
}
