<?php

namespace AdventOfCode\Season2017\Days;

class Day10 extends DefaultDay
{
    private const ARRAY_SIZE = 256;

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
        $array = $this->loadArray();
        $lengths = explode(',', $input);
        $pointer = 0;
        $skip = 0;

        foreach ($lengths as $length) {
            $to = $pointer + $length - 1;
            $this->reverseArrayInInterval($array, $pointer, $to);
            $pointer += $length + $skip;
            $skip++;
            $pointer = $pointer % self::ARRAY_SIZE;
        }

        return $array[0] * $array[1];
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $array = $this->loadArray();
        $lengths = $this->loadLenghtsForSecondPuzzle($input);
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

        $output = [];
        for ($i = 0; $i < 16; $i++) {
            $from = $i * 16;
            $to = $from + 15;
            $output[] = $this->getDenseHash($array, $from, $to);
        }

        $result = '';

        foreach ($output as $value) {
            $hex = str_pad(dechex($value), 2, '0', STR_PAD_LEFT);
            $result .= $hex;
        }

        return $result;
    }

    /**
     * @param string $input
     *
     * @return array
     */
    private function loadLenghtsForSecondPuzzle(string $input): array
    {
        $length = strlen($input);
        $result = [];

        for ($i = 0; $i < $length; $i++) {
            $result[] = ord($input[$i]);
        }

        foreach ([17, 31, 73, 47, 23] as $number) {
            $result[] = $number;
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
     * @param array $array
     *
     * @return array
     */
    private function reverseArray(array $array): array
    {
        return array_reverse($array);
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
}
