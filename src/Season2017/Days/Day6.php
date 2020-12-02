<?php

namespace AdventOfCode\Season2017\Days;

class Day6 extends DefaultDay
{
    private const BLOCKS_COUNT = 16;

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
        $blocks = $this->loadMemoryBlock($input);
        $snapshots = [$this->getBlockSnapshot($blocks)];
        $i = 0;
        while (true) {
            $this->redistribute($blocks);

            $snapshot = $this->getBlockSnapshot($blocks);
            if (in_array($snapshot, $snapshots)) {
                return $i + 1;
            }
            $snapshots[] = $snapshot;
            $i++;
        }

        return 'not found';
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $blocks = $this->loadMemoryBlock($input);
        $snapshots = [$this->getBlockSnapshot($blocks)];
        while (true) {
            $this->redistribute($blocks);

            $snapshot = $this->getBlockSnapshot($blocks);
            if (in_array($snapshot, $snapshots)) {
                $index = array_search($snapshot, $snapshots);

                return count($snapshots) - $index;
            }
            $snapshots[] = $snapshot;
        }

        return 'not found';
    }

    /**
     * @param string $input
     *
     * @return array
     */
    private function loadMemoryBlock(string $input): array
    {
        $blocks = explode("\t", $input);

        return $blocks;
    }

    /**
     * @param array $blocks
     *
     * @return int
     */
    private function getMaxIndex(array $blocks): int
    {
        $max = max($blocks);

        return array_search($max, $blocks);
    }

    /**
     * @param array $blocks
     *
     * @return string
     */
    private function getBlockSnapshot(array $blocks): string
    {
        return implode('_', $blocks);
    }

    /**
     * @param array $blocks
     */
    private function redistribute(array &$blocks)
    {
        $maxIndex = $this->getMaxIndex($blocks);
        $max = $blocks[$maxIndex];
        $blocks[$maxIndex] = 0;

        $add = ceil($max / self::BLOCKS_COUNT);

        if ($add == 0) {
            $add = 1;
        }

        $total = $max;

        for ($i = 1; $i <= self::BLOCKS_COUNT; $i++) {
            $index = ($i + $maxIndex) % self::BLOCKS_COUNT;

            if ($add > $total) {
                $add = $total;
            }

            $blocks[$index] += $add;
            $total -= $add;
        }
    }
}
