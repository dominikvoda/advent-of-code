<?php

namespace AdventOfCode\Season2017\Days;

use Exception;

class Day2 extends DefaultDay
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
        $total = 0;
        /** @var string $line */
        foreach ($input as $line) {
            $numbers = $this->getLineNumbers($line);
            $total += $this->getDifference($numbers);
        }

        return $total;
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     * @throws Exception
     */
    protected function resolveSecondPuzzle($input): string
    {
        $total = 0;
        /** @var string $line */
        foreach ($input as $line) {
            $numbers = $this->getLineNumbers($line);
            $total += $this->getDivision($numbers);
        }

        return $total;
    }

    /**
     * @param string $line
     *
     * @return array
     */
    private function getLineNumbers(string $line): array
    {
        return explode("\t", $line);
    }

    /**
     * @param array $numbers
     *
     * @return int
     */
    private function getDifference(array $numbers): int
    {
        $max = max($numbers);
        $min = min($numbers);

        return $max - $min;
    }

    /**
     * @param array $numbers
     *
     * @return int
     * @throws Exception
     */
    private function getDivision(array $numbers): int
    {
        asort($numbers);

        while (count($numbers) > 0) {
            $number = array_pop($numbers);
            $divisibleNumber = $this->getDivisibleNumber($number, $numbers);
            if ($divisibleNumber !== null) {
                return $number / $divisibleNumber;
            }
        }

        throw new Exception('Divisible number not found');
    }

    /**
     * @param int   $operand
     * @param array $choices
     *
     * @return int|null
     */
    private function getDivisibleNumber(int $operand, array $choices): ?int
    {
        foreach ($choices as $number) {
            if ($this->isDivisible($operand, $number)) {
                return $number;
            }
        }

        return null;
    }

    /**
     * @param int $number1
     * @param int $number2
     *
     * @return bool
     */
    private function isDivisible(int $number1, int $number2): bool
    {
        return is_int($number1 / $number2);
    }
}
