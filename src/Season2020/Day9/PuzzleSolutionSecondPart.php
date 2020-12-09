<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day9;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_slice;
use function array_sum;
use function count;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    private const NUMBER = 1398413738;


    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');
        $numbers = $input->getLinesAsNumbers();

        $i = 2;

        while (true) {
            $slices = $this->getNumberSlices($numbers, $i);

            foreach ($slices as $slice) {
                $sum = array_sum($slice);

                if ($sum === self::NUMBER) {
                    return new IntegerResult(min($slice) + max($slice));
                }
            }

            $i++;
        }
    }


    private function getNumberSlices(array $numbers, int $sliceSize): array
    {
        $size = count($numbers) - $sliceSize + 1;

        $slices = [];

        for ($i = 0; $i < $size; $i++) {
            $slices[] = array_slice($numbers, $i, $sliceSize);
        }

        return $slices;
    }
}
