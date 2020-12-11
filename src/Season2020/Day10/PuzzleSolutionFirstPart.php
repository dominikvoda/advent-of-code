<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day10;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function sort;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $numbers = $input->getLinesAsNumbers();
        sort($numbers);

        $differences = [
            1 => $numbers[0],
            2 => 0,
            3 => 1,
        ];

        for ($i = 1; $i < $input->getSize(); $i++) {
            $difference = $numbers[$i] - $numbers[$i - 1];
            $differences[$difference]++;
        }

        return new IntegerResult($differences[1] * $differences[3]);
    }
}
