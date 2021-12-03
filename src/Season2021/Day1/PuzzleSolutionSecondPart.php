<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day1;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use const PHP_INT_MAX;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    /**
     * @var int[]
     */
    private $numbers;

    /**
     * @var int
     */
    private $length;


    public function __construct()
    {
        $input = new LinesInput(__DIR__ . '/input.txt');
        $this->numbers = $input->getLinesAsNumbers();
        $this->length = $input->getSize();
    }


    public function getResult(): Result
    {
        $increments = 0;
        $current = PHP_INT_MAX;

        for ($i = 2; $i < $this->length; $i++) {
            $total = $this->numbers[$i] + $this->numbers[$i - 1] + $this->numbers[$i - 2];
            if ($total > $current) {
                $increments++;
            }

            $current = $total;
        }

        return new IntegerResult($increments);
    }
}
