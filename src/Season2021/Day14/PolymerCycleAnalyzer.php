<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day14;

use function array_map;
use function array_pop;
use function array_shift;
use function asort;
use function strlen;

final class PolymerCycleAnalyzer
{
    public static function analyze(string $polymer, array $rules, int $cycles): array{
        $length = strlen($polymer);

        $pairs = [];
        for($i = 1; $i < $length; $i++) {
            $key = $polymer[$i - 1] . $polymer[$i];
            $pairs[$key] = $pairs[$key] ?? 0;
            $pairs[$key]++;
        }

        for ($i = 0; $i < $cycles; $i++) {
            $newPairs = [];
            foreach ($rules as $key => $replacement) {
                if(!isset($pairs[$key])){
                    continue;
                }

                $number = $pairs[$key];

                $pair1 = $key[0] . $replacement;
                $pair2 = $replacement . $key[1];

                $newPairs[$pair1] = $newPairs[$pair1] ?? 0;
                $newPairs[$pair2] = $newPairs[$pair2] ?? 0;

                $newPairs[$pair1] += $number;
                $newPairs[$pair2] += $number;
            }

            $pairs = $newPairs;
        }

        $total = [];
        foreach ($pairs as $pair => $number) {
            $total[$pair[0]] = $total[$pair[0]] ?? 0;
            $total[$pair[1]] = $total[$pair[1]] ?? 0;
            $total[$pair[0]] += $number / 2;
            $total[$pair[1]] += $number / 2;
        }

        $total = array_map('round', $total);
        $total = array_map('intval', $total);

        asort($total);

        $max = array_pop($total);
        $min = array_shift($total);

        return ['min' => $min, 'max' => $max];
    }
}
