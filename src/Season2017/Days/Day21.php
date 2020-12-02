<?php

namespace AdventOfCode\Season2017\Days;

use InvalidArgumentException;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class Day21 extends DefaultDay
{
    /**
     * @return array
     */
    private function initGrid(): array
    {
        return [
            ['.', '#', '.'],
            ['.', '.', '#'],
            ['#', '#', '#'],
        ];
    }

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
        $rules = $this->loadRules($input);
        $grid = $this->createGrid($rules, 5);

        return $this->countLights($grid);
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $rules = $this->loadRules($input);
        $grid = $this->createGrid($rules, 18);

        return $this->countLights($grid);
    }

    /**
     * @param array $grid
     *
     * @return int
     */
    private function countLights(array $grid): int
    {
        $total = 0;

        $size = count($grid);
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                if ($grid[$i][$j] === '#') {
                    $total++;
                }
            }
        }

        return $total;
    }

    /**
     * @param array $rules
     * @param int   $iterations
     *
     * @return array
     */
    private function createGrid(array $rules, int $iterations): array
    {
        $grid = $this->initGrid();

        $progressBar = new ProgressBar(new ConsoleOutput());
        $progressBar->setRedrawFrequency(1);
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');
        $progressBar->start($iterations);

        for ($i = 0; $i < $iterations; $i++) {
            $size = count($grid);

            if ($size % 2 === 0) {
                $dividedGrids = $this->getDividedGrids($grid, 2);
            } else {
                $dividedGrids = $this->getDividedGrids($grid, 3);
            }

            $replacedDividedGrids = [];

            /** @var array $dividedGrid */
            foreach ($dividedGrids as $dividedGrid) {
                $variants = $this->getAllGridVariants($dividedGrid['grid']);
                $ruleReplace = $this->findRule($variants, $rules);
                $replacedDividedGrids[] = [
                    'grid'    => $this->restoreGridFromStamp($ruleReplace),
                    'offsetX' => $dividedGrid['offsetX'],
                    'offsetY' => $dividedGrid['offsetY'],
                ];
            }
            $grid = $this->concatDividedGrids($replacedDividedGrids);
            $progressBar->advance();
        }

        $progressBar->finish();

        return $grid;
    }

    /**
     * @param array $grid
     *
     * @return array
     */
    private function getAllGridVariants(array $grid): array
    {
        $variants = [];
        $currentGrid = $grid;
        for ($i = 0; $i < 4; $i++) {
            $variants[] = $this->getArrayStamp($currentGrid);
            $variants[] = $this->getArrayStamp($this->flipHorizontal($currentGrid));
            $variants[] = $this->getArrayStamp($this->flipVertical($currentGrid));
            $currentGrid = $this->rotateRight($currentGrid);
        }

        return array_unique($variants);
    }

    /**
     * @param array $array
     *
     * @return array
     */
    private function rotateRight(array $array): array
    {
        array_unshift($array, null);
        $newGrid = call_user_func_array('array_map', $array);
        $newGrid = array_map('array_reverse', $newGrid);

        return $newGrid;
    }

    /**
     * @param array $array
     *
     * @return array
     */
    private function flipVertical(array $array): array
    {
        $flippedArray = [];
        /** @var array $item */
        foreach ($array as $item) {
            $flippedArray[] = $this->flipArray($item);
        }

        return $flippedArray;
    }

    /**
     * @param array $array
     *
     * @return array
     */
    private function flipHorizontal(array $array): array
    {
        return $this->flipArray($array);
    }

    /**
     * @param array $array
     *
     * @return array
     */
    private function flipArray(array $array): array
    {
        $flippedArray = [];
        $pointer = count($array) - 1;

        for ($i = $pointer; $i >= 0; $i--) {
            $flippedArray[] = $array[$i];
        }

        return $flippedArray;
    }

    /**
     * @param array $array
     *
     * @return string
     */
    private function getArrayStamp(array $array): string
    {
        $rowStamps = [];
        /** @var array $item */
        foreach ($array as $item) {
            $rowStamps[] = join('', $item);
        }

        return join('/', $rowStamps);
    }

    /**
     * @param array $input
     *
     * @return array
     */
    private function loadRules(array $input): array
    {
        $rules = [];
        /** @var string $row */
        foreach ($input as $row) {
            $parts = explode(' => ', $row);
            $rules[$parts[0]] = $parts[1];
        }

        return $rules;
    }

    /**
     * @param string $stamp
     *
     * @return array
     */
    private function restoreGridFromStamp(string $stamp): array
    {
        $parts = explode('/', $stamp);
        $grid = [];
        foreach ($parts as $part) {
            $grid[] = str_split($part);
        }

        return $grid;
    }

    /**
     * @param array $variants
     * @param array $rules
     *
     * @return string
     */
    private function findRule(array $variants, array $rules): string
    {
        /** @var string $variant */
        foreach ($variants as $variant) {
            if (array_key_exists($variant, $rules)) {
                return $rules[$variant];
            }
        }

        throw new InvalidArgumentException('Rule not found');
    }

    /**
     * @param array $dividedGrids
     *
     * @return array
     */
    private function concatDividedGrids(array $dividedGrids): array
    {
        $grid = [];
        /** @var array $dividedGrid */
        foreach ($dividedGrids as $dividedGrid) {
            $offsetX = $dividedGrid['offsetX'];
            $offsetY = $dividedGrid['offsetY'];
            $size = count($dividedGrid['grid']);
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    $grid[$i + $offsetX][$j + $offsetY] = $dividedGrid['grid'][$i][$j];
                }
            }
        }

        return $grid;
    }

    /**
     * @param array $grid
     * @param int   $partSize
     *
     * @return array
     */
    private function getDividedGrids(array $grid, int $partSize): array
    {
        $size = count($grid);
        $parts = $size / $partSize;

        $dividedGrids = [];

        for ($i = 0; $i < $parts; $i++) {
            for ($j = 0; $j < $parts; $j++) {
                $offsetX = $i * $partSize;
                $offsetY = $j * $partSize;
                $gridSubset = [
                    'grid'    => $this->getArraySubset($offsetX, $offsetY, $partSize, $grid),
                    'offsetX' => $i * ($partSize + 1),
                    'offsetY' => $j * ($partSize + 1),
                ];
                $dividedGrids[] = $gridSubset;
            }
        }

        return $dividedGrids;
    }

    /**
     * @param int   $x
     * @param int   $y
     * @param int   $size
     * @param array $array
     *
     * @return array
     */
    private function getArraySubset(int $x, int $y, int $size, array $array): array
    {
        $result = [];
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                $result[$i][$j] = $array[$i + $x][$j + $y];
            }
        }

        return $result;
    }
}
