<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day9;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;
use function array_map;
use function array_slice;
use function in_array;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    const PREAMBLE_SIZE = 25;


    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');
        $numbers = $input->getLinesAsNumbers();

        for ($i = self::PREAMBLE_SIZE; $i < $input->getSize(); $i++) {
            $preamble = array_slice($numbers, $i - self::PREAMBLE_SIZE, self::PREAMBLE_SIZE);
            $number = $numbers[$i];

            $allResults = $this->findAllCombinationsResults($preamble);

            if (!in_array($number, $allResults, true)) {
                return new IntegerResult($number);
            }
        }

        throw new LogicException('Oh no!');
    }


    private function findAllCombinationsResults(array $preamble): array
    {
        $combinations = [];
        foreach ($preamble as $a => $numberA) {
            foreach ($preamble as $b => $numberB) {
                if ($a === $b) {
                    continue;
                }

                $combinations[] = [$numberA, $numberB];
            }
        }

        return array_map('array_sum', $combinations);
    }
}
