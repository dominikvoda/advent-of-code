<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day3;

final class MostCommonValueFinder
{
    public static function find(array $lines, int $position): string
    {
        $half = count($lines) / 2;
        $zeros = 0;
        foreach ($lines as $line) {
            if ($line[$position] === '0') {
                $zeros++;
            }
        }

        if ($zeros === $half) {
            return '1';
        }

        return $zeros > $half ? '0' : '1';
    }
}
