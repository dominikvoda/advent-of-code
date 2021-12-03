<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day3;

use AdventOfCode\IntegerResult;
use AdventOfCode\InvalidResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function bindec;

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
        $gamma = '';
        $epsilon = '';

        for ($i = 0; $i < 12; $i++) {
            $mostCommon = MostCommonValueFinder::find($this->lines, $i);

            $gamma .= $mostCommon === '0' ? '0' : '1';
            $epsilon .= $mostCommon === '0' ? '1' : '0';
        }

        return new IntegerResult(bindec($gamma) * bindec($epsilon));
    }
}
