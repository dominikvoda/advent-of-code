<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day1;

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
    private $numbers;


    public function __construct()
    {
        $input = new LinesInput(__DIR__ . '/input.txt');
        $this->numbers = $input->getLinesAsNumbers();
    }


    public function getResult(): Result
    {
        $increments = 0;
        $current = PHP_INT_MAX;

        foreach ($this->numbers as $number) {
            if ($number > $current) {
                $increments++;
            }
            $current = $number;
        }

        return new IntegerResult($increments);
    }
}
