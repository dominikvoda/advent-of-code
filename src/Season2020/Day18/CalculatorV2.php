<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day18;

use Nette\Utils\Strings;
use function array_map;
use function array_shift;
use function explode;
use function str_replace;

final class CalculatorV2
{
    public static function solve(string $example): int
    {
        $example = ' ' . $example . ' ';
        $example = str_replace(['(', ')', '  '], [' ( ', ' ) ', ' '], $example);

        if (self::hasParentheses($example)) {
            return self::solve(self::solveParentheses($example));
        }

        return self::calc($example);
    }


    private static function solveParentheses(string $example): string
    {
        preg_match_all('/\((\d|[+* ])+\)/', $example, $matches);

        $result = $example;

        foreach ($matches[0] as $match) {
            $result = str_replace($match, self::calc($match), $result);
        }

        return $result;
    }


    private static function calc(string $example): int
    {
        if (self::hasAddition($example)) {
            $example = self::solveAdditions($example);
        }

        preg_match_all('/\d+/', $example, $matches);

        $operands = $matches[0];
        $result = (int)array_shift($operands);

        while ($operands !== []) {
            $nextOperand = (int)array_shift($operands);

            $result *= $nextOperand;
        }

        return $result;
    }


    private static function solveAdditions(string $example): string
    {
        preg_match_all('/ \d+ \+ \d+ /', $example, $matches);

        $result = $example;

        foreach ($matches[0] as $match) {
            $operands = array_map('trim', explode('+', $match));
            $operands = array_map('intval', $operands);

            $result = str_replace($match, ' ' . ($operands[0] + $operands[1]) . ' ', $example);
        }

        if (self::hasAddition($result)) {
            return self::solveAdditions($result);
        }

        return $result;
    }


    private static function hasParentheses(string $example): bool
    {
        return Strings::contains($example, '(');
    }


    private static function hasAddition(string $example): bool
    {
        return Strings::contains($example, '+');
    }
}
