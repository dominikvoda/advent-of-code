<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day1;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function in_array;

class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $frequency = 0;
        $changeList = [$frequency];

        while (true) {
            foreach ($input->getLines() as $change) {
                $frequency += (int)$change;
                if (in_array($frequency, $changeList, true)) {
                    return new IntegerResult($frequency);
                }

                $changeList[] = $frequency;
            }
        }
    }
}
