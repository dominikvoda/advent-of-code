<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day4;

use function array_filter;
use function array_map;
use function array_merge;
use function array_search;
use function array_sum;
use function explode;
use function str_replace;

final class BingoBoard
{
    /**
     * @var int[]|null[]
     */
    private $rows;


    public function __construct(array $input)
    {
        $rows = array_map('trim', array_filter($input, 'strlen'));
        $this->rows = array_merge(
            ...array_map(static function (string $row): array {
                $row = str_replace('  ', ' ', $row);
                return array_map('intval', explode(' ', $row));
            }, $rows)
        );
    }


    public function play(int $number): bool
    {
        $index = array_search($number, $this->rows, true);

        if ($index === false) {
            return false;
        }

        $this->rows[$index] = null;

        return $this->checkRows() || $this->checkColumns();
    }


    public function getSumOfLeft(): int
    {
        return array_sum(array_filter($this->rows, 'is_int'));
    }


    private function checkRows(): bool
    {
        $offsets = [0, 1, 2, 3, 4];
        for ($i = 0; $i < 25; $i += 5) {
            foreach ($offsets as $offset) {
                if ($this->rows[$i + $offset] !== null) {
                    continue 2;
                }
            }

            return true;
        }

        return false;
    }


    private function checkColumns(): bool
    {
        $offsets = [0, 5, 10, 15, 20];
        for ($i = 0; $i < 5; $i++) {
            foreach ($offsets as $offset) {
                if ($this->rows[$i + $offset] !== null) {
                    continue 2;
                }
            }

            return true;
        }

        return false;
    }
}
