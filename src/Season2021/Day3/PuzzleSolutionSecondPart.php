<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day3;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_filter;
use function bindec;
use function count;
use function end;

final class PuzzleSolutionSecondPart implements PuzzleSolution
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
        $generatorLines = $this->lines;
        $scrubberLines = $this->lines;
        $position = 0;

        while (count($generatorLines) > 1) {
            $mostCommon = MostCommonValueFinder::find($generatorLines, $position);

            $generatorLines = array_filter($generatorLines, static function (string $line) use ($position, $mostCommon): bool {
                return $line[$position] === $mostCommon;
            });

            $position++;
        }

        $position = 0;

        while (count($scrubberLines) > 1) {
            $mostCommon = MostCommonValueFinder::find($scrubberLines, $position) === '1' ? '0' : '1';

            $scrubberLines = array_filter($scrubberLines, static function (string $line) use ($position, $mostCommon): bool {
                return $line[$position] === $mostCommon;
            });
            $position++;
        }

        $generator = bindec(end($generatorLines));
        $scrubber = bindec(end($scrubberLines));

        return new IntegerResult($generator * $scrubber);
    }
}
