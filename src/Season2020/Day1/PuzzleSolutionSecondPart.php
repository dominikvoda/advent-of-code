<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day1;

use AdventOfCode\Season2020\LinesInput;
use AdventOfCode\Season2020\PuzzleSolution;
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


    public function getResult(): string
    {
        while (count($this->numbers) > 0) {
            $firstOperand = array_pop($this->numbers);

            $missingNumbers = NumbersFinder::findNumbersAndMultiply($this->numbers, self::RESULT - $firstOperand);

            if ($missingNumbers !== null) {
                return (string)($missingNumbers * $firstOperand);
            }
        }

        return 'Not found';
    }
}
