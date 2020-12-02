<?php

namespace AdventOfCode\Season2017\Days;

class Day14 extends DefaultDay
{
    private const ARRAY_SIZE = 256;

    /**
     * @return string
     */
    protected function getInputType(): string
    {
        return self::INPUT_DIRECT;
    }

    /**
     * @return string
     */
    protected function getDirectInput(): string
    {
        return 'ljoxqyyw';
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveFirstPuzzle($input): string
    {
        $binaryStrings = $this->getBinaryArray($input);

        return $this->calcUsed(implode('', $binaryStrings));
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $binaryStrings = $this->getBinaryArray($input);
        $grid = [];

        for ($i = 0; $i < 128; $i++) {
            for ($j = 0; $j < 128; $j++) {
                $key = $this->getGridKey($i, $j);
                $grid[$key] = $binaryStrings[$i][$j];
            }
        }

        $groups = 0;
        $visitedKeys = [];

        for ($i = 0; $i < 128; $i++) {
            for ($j = 0; $j < 128; $j++) {
                $key = $this->getGridKey($i, $j);
                if ($grid[$key] == 1 && !$this->isVisited($visitedKeys, $i, $j)) {
                    $this->exploreGroup($grid, $visitedKeys, $i, $j);
                    $groups++;
                }
            }
        }

        return $groups;
    }

    /**
     * @param array $grid
     * @param array $visitedKeys
     * @param int   $x
     * @param int   $y
     */
    private function exploreGroup(array &$grid, array &$visitedKeys, int $x, int $y): void
    {
        $keyX = $this->getGridKey($x + 1, $y);
        $keyY = $this->getGridKey($x, $y + 1);

        $keyXX = $this->getGridKey($x - 1, $y);
        $keyYY = $this->getGridKey($x, $y - 1);

        if (isset($grid[$keyX]) && !$this->isVisited($visitedKeys, $x + 1, $y) && $grid[$keyX] == 1) {
            $visitedKeys[] = $keyX;
            $this->exploreGroup($grid, $visitedKeys, $x + 1, $y);
        }

        if (isset($grid[$keyY]) && !$this->isVisited($visitedKeys, $x, $y + 1) && $grid[$keyY] == 1) {
            $visitedKeys[] = $keyY;
            $this->exploreGroup($grid, $visitedKeys, $x, $y + 1);
        }

        if (isset($grid[$keyXX]) && !$this->isVisited($visitedKeys, $x - 1, $y) && $grid[$keyXX] == 1) {
            $visitedKeys[] = $keyXX;
            $this->exploreGroup($grid, $visitedKeys, $x - 1, $y);
        }

        if (isset($grid[$keyYY]) && !$this->isVisited($visitedKeys, $x, $y - 1) && $grid[$keyYY] == 1) {
            $visitedKeys[] = $keyYY;
            $this->exploreGroup($grid, $visitedKeys, $x, $y - 1);
        }
    }

    /**
     * @param int $x
     * @param int $y
     *
     * @return string
     */
    private function getGridKey(int $x, int $y): string
    {
        return sprintf('%s_%s', $x, $y);
    }

    /**
     * @param array $visitedKeys
     * @param int   $x
     * @param int   $y
     *
     * @return bool
     */
    private function isVisited(array &$visitedKeys, int $x, int $y): bool
    {
        $key = $this->getGridKey($x, $y);

        return in_array($key, $visitedKeys);
    }

    /**
     * @param string $input
     *
     * @return array
     */
    private function getBinaryArray(string $input): array
    {
        $rows = $this->loadRows($input);
        $binaryStrings = [];
        /** @var string $row */
        foreach ($rows as $row) {
            $array = $this->loadArray();
            $lengths = $this->loadNumbers($row);
            $pointer = 0;
            $skip = 0;

            for ($i = 0; $i < 64; $i++) {
                foreach ($lengths as $length) {
                    $to = $pointer + $length - 1;
                    $this->reverseArrayInInterval($array, $pointer, $to);
                    $pointer += $length + $skip;
                    $skip++;
                    $pointer = $pointer % self::ARRAY_SIZE;
                }
            }

            $denseHashes = [];

            for ($i = 0; $i < 16; $i++) {
                $from = $i * 16;
                $to = $from + 15;
                $denseHashes[] = $this->getDenseHash($array, $from, $to);
            }

            $knowHash = $this->getKnotHash($denseHashes);
            $binaryStrings[] = $this->getBinaryFromHex($knowHash);
        }

        return $binaryStrings;
    }

    /**
     * @param array $denseHashes
     *
     * @return string
     */
    private function getKnotHash(array $denseHashes): string
    {
        $hexOutput = '';
        foreach ($denseHashes as $value) {
            $hex = str_pad(dechex($value), 2, '0', STR_PAD_LEFT);
            $hexOutput .= $hex;
        }

        return $hexOutput;
    }

    /**
     * @param string $hex
     *
     * @return string
     */
    private function getBinaryFromHex(string $hex): string
    {
        $length = strlen($hex);
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $dec = hexdec($hex[$i]);
            $result .= str_pad(decbin($dec), 4, '0', STR_PAD_LEFT);
        }

        return $result;
    }

    /**
     * @param array $array
     * @param int   $from
     * @param int   $to
     */
    private function reverseArrayInInterval(array &$array, int $from, int $to): void
    {
        $subArray = $this->getCircleSubArray($array, $from, $to);
        $reversed = $this->reverseArray($subArray);
        $j = 0;

        for ($i = $from; $i <= $to; $i++) {
            $array[$i % self::ARRAY_SIZE] = $reversed[$j];
            $j++;
        }
    }

    /**
     * @param array $array
     * @param int   $from
     * @param int   $to
     *
     * @return array
     */
    private function getCircleSubArray(array $array, int $from, int $to): array
    {
        $result = [];

        for ($i = $from; $i <= $to; $i++) {
            $result[] = $array[$i % self::ARRAY_SIZE];
        }

        return $result;
    }

    /**
     * @param array $array
     *
     * @return array
     */
    private function reverseArray(array $array): array
    {
        return array_reverse($array);
    }

    /**
     * @param array $array
     * @param int   $from
     * @param int   $to
     *
     * @return int
     */
    private function getDenseHash(array $array, int $from, int $to): int
    {
        $result = $array[$from];

        for ($i = $from + 1; $i <= $to; $i++) {
            $result = ($array[$i] ^ $result);
        }

        return $result;
    }

    /**
     * @param string $input
     *
     * @return array
     */
    private function loadRows(string $input): array
    {
        $rows = [];
        for ($i = 0; $i < 128; $i++) {
            $rows[] = $input . '-' . $i;
        }

        return $rows;
    }

    /**
     * @param string $row
     *
     * @return array
     */
    private function loadNumbers(string $row): array
    {
        $length = strlen($row);
        $numbers = [];

        for ($i = 0; $i < $length; $i++) {
            $numbers[] = ord($row[$i]);
        }

        foreach ([17, 31, 73, 47, 23] as $number) {
            $numbers[] = $number;
        }

        return $numbers;
    }

    /**
     * @return array
     */
    private function loadArray(): array
    {
        $array = [];
        for ($i = 0; $i < self::ARRAY_SIZE; $i++) {
            $array[] = $i;
        }

        return $array;
    }

    /**
     * @param string $binaryString
     *
     * @return int
     */
    private function calcUsed(string $binaryString): int
    {
        $total = 0;
        $length = strlen($binaryString);
        for ($i = 0; $i < $length; $i++) {
            if ($binaryString[$i] === '1') {
                $total++;
            }
        }

        return $total;
    }
}
