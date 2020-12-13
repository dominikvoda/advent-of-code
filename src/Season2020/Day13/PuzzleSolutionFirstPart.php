<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day13;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function asort;
use function key;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $timestamp = (int)$input->getLines()[0];
        preg_match_all('/\d+/', $input->getLines()[1], $numbers);

        $buses = [];

        foreach ($numbers[0] as $number) {
            $buses[$number] = $number - $timestamp % $number;
        }

        asort($buses);
        $firstKey = key($buses);

        return new IntegerResult($firstKey * $buses[$firstKey]);
    }
}
