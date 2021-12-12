<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day11;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_map;
use function in_array;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    private const AROUND = [
        [-1, -1],
        [-1, 0],
        [-1, 1],
        [0, -1],
        [0, 1],
        [1, -1],
        [1, 0],
        [1, 1],
    ];

    /**
     * @var int[]
     */
    private array $grid;

    private array $flashed;

    private int $flashes;


    public function __construct()
    {
        $points = new LinesInput(__DIR__ . '/input.txt');
        $this->grid = array_map(function (array $numbers): array {
            return array_map('intval', $numbers);
        }, $points->mapLines('str_split'));
        $this->flashed = [];
        $this->flashes = 0;
    }


    public function getResult(): Result
    {
        for ($i = 0; $i < 100; $i++) {
            foreach ($this->grid as $y => $line) {
                foreach ($line as $x => $octopus) {
                    $this->grid[$y][$x]++;
                }
            }

            foreach ($this->grid as $y => $line) {
                foreach ($line as $x => $octopus) {
                    $value = $this->grid[$y][$x];

                    if ($value < 10) {
                        continue;
                    }
                    
                    $this->flash($y, $x);
                }
            }

            $this->flashed = [];
        }

        return new IntegerResult($this->flashes);
    }


    private function flash(int $y, int $x): void
    {
        $this->flashed[] = $y . '-' . $x;
        $this->flashes++;
        $this->grid[$y][$x] = 0;

        foreach (self::AROUND as $offsets) {
            $newY = $y + $offsets[0];
            $newX = $x + $offsets[1];
            if (!isset($this->grid[$newY][$newX])) {
                continue;
            }

            $key = $newY . '-' . $newX;

            if (in_array($key, $this->flashed, true)) {
                continue;
            }

            $this->grid[$newY][$newX]++;

            if ($this->grid[$newY][$newX] >= 10) {
                $this->flash($newY, $newX);
            }
        }
    }
}
