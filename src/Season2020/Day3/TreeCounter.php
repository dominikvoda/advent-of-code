<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day3;

use AdventOfCode\Season2020\GridInput;

final class TreeCounter
{
    public static function count(GridInput $gridInput, int $xIncrements, int $yIncrements): int
    {
        $y = 0;
        $x = 0;
        $treesCount = 0;

        while ($y < $gridInput->getHeight()) {
            $char = $gridInput->getChar($y, $x);

            if ($char === '#') {
                $treesCount++;
            }

            $x += $xIncrements;
            $x %= $gridInput->getMaxWidth();

            $y += $yIncrements;
        }

        return $treesCount;
    }
}
