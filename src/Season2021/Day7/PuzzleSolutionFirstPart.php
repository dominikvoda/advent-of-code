<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day7;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use const PHP_INT_MAX;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    /**
     * @var int[]
     */
    private array $crabs;


    public function __construct()
    {
        $fish = new LinesInput(__DIR__ . '/input.txt', ',');
        $this->crabs = $fish->getLinesAsNumbers();
    }


    public function getResult(): Result
    {
        $min = min(...$this->crabs);
        $max = max(...$this->crabs);

        $range = range($min, $max);
        $minTotal = PHP_INT_MAX;

        foreach ($range as $value) {
            $total = 0;
            foreach ($this->crabs as $crab) {
                $total += abs($crab - $value);
            }

            if ($total < $minTotal) {
                $minTotal = $total;
            }
        }

        return new IntegerResult($minTotal);
    }
}
