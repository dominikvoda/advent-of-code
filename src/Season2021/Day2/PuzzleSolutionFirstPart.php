<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day2;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function explode;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    /**
     * @var string[]
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

        foreach ($this->lines as $line) {
            $parts = explode(' ', $line);
            $command = $parts[0];
            $value = (int)$parts[1];

            if ($command === 'forward') {
                $horizontal += $value;
            }

            if ($command === 'down') {
                $depth += $value;
            }

            if ($command === 'up') {
                $depth -= $value;
            }
        }

        return new IntegerResult($horizontal * $depth);
    }
}
