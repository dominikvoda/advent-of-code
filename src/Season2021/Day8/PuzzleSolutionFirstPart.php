<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day8;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_filter;
use function count;
use function in_array;
use function strlen;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    private const LENGTHS = [2, 3, 4, 7];


    public function getResult(): Result
    {
        /** @var InputLine[] $inputLines */
        $inputLines = LinesInput::createAsObjects(__DIR__ . '/input.txt', InputLine::class);

        $total = 0;
        foreach ($inputLines as $inputLine) {
            $filtered = array_filter($inputLine->getOutputs(), static function (string $output): bool {
                return in_array(strlen($output), self::LENGTHS);
            });

            $total += count($filtered);
        }

        return new IntegerResult($total);
    }
}
