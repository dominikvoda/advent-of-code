<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day9;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_map;
use function str_split;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    /**
     * @var int[]
     */
    private array $lines;


    public function __construct()
    {
        $points = new LinesInput(__DIR__ . '/input.txt');
        $this->lines = $points->mapLines(function (string $line): array {
            return array_map('intval', str_split($line));
        });
    }


    public function getResult(): Result
    {
        $around = [[-1, 0],[0, -1],[0, 1],[1, 0]];

        $riskLevels = [];

        foreach ($this->lines as $y => $line) {
            foreach ($line as $x => $point) {
                foreach ($around as $item) {
                    $nextY = $y + $item[0];
                    $nextX = $x + $item[1];

                    if(!isset($this->lines[$nextY][$nextX])){
                        continue;
                    }

                    if($this->lines[$nextY][$nextX] <= $point){
                        continue 2;
                    }
                }

                $riskLevels[] = $point + 1;
            }
        }

        return IntegerResult::fromArraySum($riskLevels);
    }
}
