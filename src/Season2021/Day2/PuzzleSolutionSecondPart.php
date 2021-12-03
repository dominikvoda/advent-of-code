<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day2;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function explode;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    /**
     * @var int[]
     */
    private $lines;


    public function __construct()
    {
        $input = new LinesInput(__DIR__ . '/input.txt');
        $this->lines = $input->getLines();
    }


    public function getResult(): Result
    {
        $horizontal = 0;
        $depth = 0;
        $aim = 0;

        foreach ($this->lines as $line) {
            $parts = explode(' ', $line);
            $command = $parts[0];
            $value = (int)$parts[1];

            if ($command === 'forward') {
                $horizontal += $value;
                $depth += $aim * $value;
            }

            if ($command === 'down') {
                $aim += $value;
            }

            if ($command === 'up') {
                $aim -= $value;
            }
        }

        return new IntegerResult($horizontal * $depth);
    }
}
