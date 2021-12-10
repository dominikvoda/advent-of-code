<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day10;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_map;
use function array_pop;
use function array_reverse;
use function array_search;
use function in_array;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    private const CLOSING = [')', ']', '}', '>'];
    private const MAP = [')' => '(', ']' => '[', '}' => '{', '>' => '<'];
    private const POINTS = [')' => 1, ']' => 2, '}' => 3, '>' => 4];

    /**
     * @var int[]
     */
    private array $lines;


    public function __construct()
    {
        $points = new LinesInput(__DIR__ . '/input.txt');
        $this->lines = $points->mapLines('str_split');
    }


    public function getResult(): Result
    {
        $fixedLines = [];

        foreach ($this->lines as $line) {
            $chars = [];

            foreach ($line as $char) {
                if (in_array($char, self::CLOSING, true)) {
                    $previous = array_pop($chars);

                    if ($previous !== self::MAP[$char]) {
                        continue 2;
                    }

                    continue;
                }

                $chars[] = $char;
            }

            $fixedLines[] = array_map(static function (string $char): string {
                return array_search($char, self::MAP, true);
            }, $chars);
        }

        $totals = [];

        foreach ($fixedLines as $line) {
            $lineTotal = 0;

            foreach (array_reverse($line) as $char) {
                $lineTotal = $lineTotal * 5 + self::POINTS[$char];
            }

            $totals[] = $lineTotal;
        }

        sort($totals);
        $middle = (count($totals) - 1) / 2;

        return new IntegerResult($totals[$middle]);
    }
}
