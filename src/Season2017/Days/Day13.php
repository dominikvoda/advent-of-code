<?php

namespace AdventOfCode\Season2017\Days;

use AdventOfCode\Season2017\Classes\Scanner;

class Day13 extends DefaultDay
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
        /** @var Scanner[] $scanners */
        $scanners = $this->loadScanners($input);

        $severity = $this->getSeverity($scanners);

        return $severity;
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        /** @var Scanner[] $scanners */
        $scanners = $this->loadScanners($input);
        $delay = 0;
        $caught = 0;
        $max = 0;

        while (null !== $caught) {
            $caught = $this->isCaught($scanners, $delay);
            $max = $caught > $max ? $caught : $max;

            echo sprintf('Delay: %s, caught: %s, max: %s', $delay, $caught, $max) . PHP_EOL;

            $delay++;
        }

        return $delay - 1;
    }

    /**
     * @param array $scanners
     *
     * @return int
     */
    private function getSeverity(array $scanners): int
    {
        $severity = 0;

        /** @var Scanner $scanner */
        foreach ($scanners as $scanner) {
            if ($scanner->isCaught()) {
                $severity += $scanner->getSeverity();
            }
        }

        return $severity;
    }

    /**
     * @param array $scanners
     * @param int   $delay
     *
     * @return null|int
     */
    private function isCaught(array $scanners, int $delay): ?int
    {
        /** @var Scanner $scanner */
        foreach ($scanners as $scanner) {
            if ($scanner->isCaught($delay)) {
                return $scanner->getColumn();
            }
        }

        return null;
    }

    /**
     * @param array $input
     *
     * @return array
     */
    private function loadScanners(array $input): array
    {
        $scanners = [];
        foreach ($input as $line) {
            $parts = explode(': ', $line);
            $scanners[$parts[0]] = new Scanner($parts[1], $parts[0]);
        }

        return $scanners;
    }
}
