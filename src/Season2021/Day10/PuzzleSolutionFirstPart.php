<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day10;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_pop;
use function in_array;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    private const CLOSING = [')', ']', '}', '>'];
    private const MAP = [')' => '(', ']' => '[', '}' => '{', '>' => '<'];
    private const ERROR_SCORE = [')' => 3, ']' => 57, '}' => 1197, '>' => 25137];

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
        $errorScore = [];

        foreach ($this->lines as $line) {
            $chars = [];
            foreach ($line as $char) {
                if (in_array($char, self::CLOSING, true)) {
                    $previous = array_pop($chars);

                    if ($previous !== self::MAP[$char]) {
                        $errorScore[] = self::ERROR_SCORE[$char];
                        continue 2;
                    }

                    continue;
                }

                $chars[] = $char;
            }
        }

        return IntegerResult::fromArraySum($errorScore);
    }
}
