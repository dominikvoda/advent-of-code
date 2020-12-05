<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day2;

use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use LogicException;
use function array_diff_assoc;
use function array_keys;
use function count;
use function implode;

class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): string
    {
        $input = new LinesInput(__DIR__ . '/input.txt');
        $inputLines = $input->mapLines('str_split');

        foreach ($inputLines as $key => $inputLine) {
            unset($inputLines[$key]);

            foreach ($inputLines as $inputLineToCompare) {
                $arrayDiff = array_diff_assoc($inputLine, $inputLineToCompare);

                if (count($arrayDiff) === 1) {
                    $keys = array_keys($arrayDiff);

                    unset($inputLineToCompare[$keys[0]]);

                    return implode('', $inputLineToCompare);
                }
            }
        }

        throw new LogicException('Oh no!');
    }
}
