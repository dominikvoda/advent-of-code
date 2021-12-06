<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day6;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    /**
     * @var int[]
     */
    private array $fish;


    public function __construct()
    {
        $fish = new LinesInput(__DIR__ . '/input.txt', ',');
        $this->fish = $fish->getLinesAsNumbers();
    }


    public function getResult(): Result
    {
        $fishCount = FishCounter::count($this->fish, 80);

        return new IntegerResult($fishCount);
    }
}
