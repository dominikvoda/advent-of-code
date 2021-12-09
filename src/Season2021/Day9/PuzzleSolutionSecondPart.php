<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day9;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_map;
use function array_pop;
use function str_split;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    private const AROUND = [[-1, 0],[0, -1],[0, 1],[1, 0]];

    /**
     * @var int[]
     */
    private array $lines;

    private int $currentBasin = 0;

    /**
     * @var int[]
     */
    private array $basins = [];


    public function __construct()
    {
        $points = new LinesInput(__DIR__ . '/input.txt');
        $this->lines = $points->mapLines(function (string $line): array {
            return array_map('intval', str_split($line));
        });
    }


    public function getResult(): Result
    {
        foreach ($this->lines as $y => $line) {
            foreach ($line as $x => $point) {
                $current = $this->lines[$y][$x];

                if($current !== 9 && $current >= 0){
                    $this->nextBasin();
                }

                $this->findBasin($y, $x);
            }
        }

        sort($this->basins);

        return new IntegerResult(array_pop($this->basins) * array_pop($this->basins) * array_pop($this->basins));
    }


    private function findBasin(int $y, int $x): void
    {
        if (!isset($this->lines[$y][$x])) {
            return;
        }

        $value = $this->lines[$y][$x];

        if ($value === 9 || $value < 0) {
            return;
        }

        $this->lines[$y][$x] = $this->currentBasin;
        $this->basins[$this->currentBasin]++;

        foreach (self::AROUND as $item) {
            $nextY = $y + $item[0];
            $nextX = $x + $item[1];
            $this->findBasin($nextY, $nextX);
        }
    }


    private function nextBasin(): void
    {
        $this->currentBasin--;
        $this->basins[$this->currentBasin] = 0;
    }
}
