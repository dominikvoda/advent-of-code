<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day18;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_map;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $results = array_map(
            static function (string $example): int {
                return Calculator::solve($example);
            },
            $input->getLines()
        );

        return IntegerResult::fromArraySum($results);
    }
}
