<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day18;

use Nette\Utils\Strings;
use function array_shift;
use function str_replace;

final class Calculator
{
    public static function solve(string $example): int
    {
        if (self::hasParentheses($example)) {
            return self::solve(self::solveParentheses($example));
        }

        return self::calc($example);
    }


    private static function solveParentheses(string $example): string
    {
        preg_match_all('/\(([0-9]|[ + , * ])+\)/', $example, $matches);

        $result = $example;

        foreach ($matches[0] as $match) {
            $result = str_replace($match, self::calc($match), $result);
        }

        return $result;
    }


    private static function calc(string $example): int
    {
        preg_match_all('/\d+|[+*]/', $example, $matches);

        $operands = $matches[0];
        $result = (int)array_shift($operands);

        while ($operands !== []) {
            $operation = array_shift($operands);
            $nextOperand = (int)array_shift($operands);

            $operation === '*' ? $result *= $nextOperand : $result += $nextOperand;
        }

        return $result;
    }


    private static function hasParentheses(string $example): bool
    {
        return Strings::contains($example, '(');
    }
}
