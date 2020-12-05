<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day5;

use function str_split;
use function substr;

final class Seat
{
    /**
     * @var string[]
     */
    private $rowLetters;

    /**
     * @var string[]
     */
    private $columnLetters;


    public function __construct(string $seat)
    {
        $this->rowLetters = str_split(substr($seat, 0, 7));
        $this->columnLetters = str_split(substr($seat, 7, 3));
    }


    public function getRow(): int
    {
        $range = [0, 127];
        $partSize = 128;

        foreach ($this->rowLetters as $value) {
            $partSize /= 2;
            if ($value === 'F') {
                $range[1] -= $partSize;
            }

            if ($value === 'B') {
                $range[0] += $partSize;
            }
        }

        return $range[0];
    }


    public function getColumn(): int
    {
        $range = [0, 7];
        $partSize = 8;

        foreach ($this->columnLetters as $value) {
            $partSize /= 2;
            if ($value === 'L') {
                $range[1] -= $partSize;
            }

            if ($value === 'R') {
                $range[0] += $partSize;
            }
        }

        return $range[0];
    }


    public function getSeatId(): int
    {
        return $this->getRow() * 8 + $this->getColumn();
    }
}
