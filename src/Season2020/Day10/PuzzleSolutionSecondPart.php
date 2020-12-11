<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day10;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_intersect;
use function array_search;
use function sort;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    /**
     * @var int[]
     */
    private $numbers;

    /**
     * @var int
     */
    private $count;

    /**
     * @var int[]
     */
    private $results;


    public function __construct()
    {
        $input = new LinesInput(__DIR__ . '/input.txt');
        $this->numbers = $input->getLinesAsNumbers();
        $this->numbers[] = 0;
        sort($this->numbers);
        $this->count = count($this->numbers);
        $this->results = [];
    }


    public function getResult(): Result
    {
        return new IntegerResult($this->getSize(0));
    }


    public function getSize(int $index): int
    {
        if ($index === $this->count - 1) {
            return 1;
        }

        if (isset($this->results[$index])) {
            return $this->results[$index];
        }

        $currentNumber = $this->numbers[$index];
        $nextNumbers = array_intersect([$currentNumber + 1, $currentNumber + 2, $currentNumber + 3], $this->numbers);

        $result = 0;

        foreach ($nextNumbers as $nextNumber) {
            $result += $this->getSize(array_search($nextNumber, $this->numbers, true));
        }

        $this->results[$index] = $result;

        return $result;
    }
}
