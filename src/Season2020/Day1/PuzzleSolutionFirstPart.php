<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day1;

use AdventOfCode\Season2020\LinesInput;
use AdventOfCode\Season2020\PuzzleSolution;

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


    public function getResult(): string
    {
        $result = NumbersFinder::findNumbersAndMultiply($this->numbers, self::RESULT);

        if ($result !== null) {
            return (string)$result;
        }

        return 'Not found';
    }
}
