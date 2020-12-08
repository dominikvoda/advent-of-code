<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day8;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use InvalidArgumentException;
use LogicException;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $accumulator = new Accumulator();

        try {
            Game::run($accumulator, $input->getLines());
        } catch (InvalidArgumentException $exception) {
            return new IntegerResult($accumulator->getValue());
        }

        throw new LogicException('Oh no!');
    }
}
