<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Day4;

use function array_map;
use function str_split;

class NumberInput
{
    /**
     * @var int
     */
    private $input;

    /**
     * @var int
     */
    private $size;

    /**
     * @var int[]
     */
    private $digits;


    public function __construct(int $input)
    {
        $this->input = $input;
        $this->size = 6;
        $this->digits = array_map(
            static function (string $digit): int {
                return (int)$digit;
            },
            str_split((string)$this->input)
        );
    }


    public function isNotDecreasing(): bool
    {
        $current = $this->digits[0];

        for ($i = 1; $i < $this->size; $i++) {
            if ($this->digits[$i] < $current) {
                return false;
            }

            $current = $this->digits[$i];
        }

        return true;
    }


    public function hasDouble(): bool
    {
        $current = $this->digits[0];

        for ($i = 1; $i < $this->size; $i++) {
            if ($this->digits[$i] === $current) {
                return true;
            }

            $current = $this->digits[$i];
        }

        return false;
    }


    public function hasOneDouble(): bool
    {
        $doubles = array_count_values($this->digits);

        foreach ($doubles as $double) {
            if ($double === 2) {
                return true;
            }
        }

        return false;
    }


    public function getInput(): int
    {
        return $this->input;
    }
}
