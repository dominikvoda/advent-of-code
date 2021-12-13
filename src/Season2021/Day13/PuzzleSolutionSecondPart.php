<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day13;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_filter;
use function array_keys;
use function array_map;
use function count;
use function explode;
use function preg_match;
use const PHP_EOL;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function __construct()
    {
        $input = new LinesInput(__DIR__ . '/input.txt', PHP_EOL . PHP_EOL);
        $this->dots = $this->loadDots($input->getLines()[0]);
        $this->folds = $this->loadFolds($input->getLines()[1]);
    }


    public function getResult(): Result
    {
        foreach ($this->folds as $fold) {
            $this->fold($fold['side'], $fold['line']);
        }

        $dots = array_filter($this->dots, function (array $line): bool{
            return count($line) > 0;
        });

        $maxX = max(array_keys($dots));
        $maxY = 0;

        foreach ($dots as $line) {
            if (count($line) > $maxY) {
                $maxY = count($line);
            }
        }

        for ($y = 0; $y <= $maxY; $y++) {
            for ($x = 0; $x <= $maxX; $x++) {
                if (isset($this->dots[$x][$y])) {
                    echo '#';
                    continue;
                }

                echo ' ';
            }
            echo PHP_EOL;
        }

        return new IntegerResult(0);
    }


    private function fold(string $side, int $line): void
    {
        foreach ($this->dots as $x => $column) {
            if ($side === 'x' && $x < $line) {
                continue;
            }

            foreach ($column as $y => $dot) {
                if ($side === 'y' && $y < $line) {
                    continue;
                }

                unset($this->dots[$x][$y]);

                $newX = $side === 'x' ? $line - ($x - $line) : $x;
                $newY = $side === 'y' ? $line - ($y - $line) : $y;
                $this->dots[$newX][$newY] = true;
            }
        }
    }


    private function loadDots(string $coordinates): array
    {
        $lines = explode(PHP_EOL, $coordinates);
        $dots = [];

        foreach ($lines as $line) {
            [$x, $y] = explode(',', $line);
            $dots[$x][$y] = true;
        }

        return $dots;
    }


    private function loadFolds(string $folds): array
    {
        $lines = explode(PHP_EOL, $folds);

        return array_map(function (string $line): array {
            preg_match('/fold along (?<side>[x,y])=(?<line>\d+)/', $line, $result);

            return [
                'side' => $result['side'],
                'line' => (int)$result['line'],
            ];
        }, $lines);
    }
}
