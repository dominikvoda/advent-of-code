<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day1;

use function array_pop;
use function count;

final class NumbersFinder
{
    public static function findNumbersAndMultiply(array $numbers, int $expectedResult): ?int
    {
        while (count($numbers) > 0) {
            $firstOperand = array_pop($numbers);

            if($firstOperand >= $expectedResult){
                continue;
            }

            foreach ($numbers as $number) {
                if ($firstOperand + $number === $expectedResult) {
                    return $firstOperand * $number;
                }
            }
        }

        return null;
    }
}
