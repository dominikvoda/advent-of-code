<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day1;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;
use function array_pop;
use function count;

final class PuzzleSolutionSecondPart implements PuzzleSolution
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
        while (count($this->numbers) > 0) {
            $firstOperand = array_pop($this->numbers);

            $missingNumbers = NumbersFinder::findNumbersAndMultiply($this->numbers, self::RESULT - $firstOperand);

            if ($missingNumbers !== null) {
                return new IntegerResult($missingNumbers * $firstOperand);
            }
        }

        throw new LogicException('Oh no!');
    }
}
