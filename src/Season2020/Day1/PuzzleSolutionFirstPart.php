<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day1;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    private const RESULT = 2020;

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
        $result = NumbersFinder::findNumbersAndMultiply($this->numbers, self::RESULT);

        if ($result !== null) {
            return new IntegerResult($result);
        }

        throw new LogicException('Oh no!');
    }
}
