<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day4;

use function array_merge;
use function array_shift;
use function range;

final class SleepingCounter
{
    /**
     * @param Record[] $records
     *
     * @return int[]
     */
    public static function getSleepingMinutes(array $records): array
    {
        $minutes = [];

        while($records !== []){
            $fallsAsleep = array_shift($records);
            $wakesUp = array_shift($records);

            $minutes = array_merge($minutes, range($fallsAsleep->getMinutes(), $wakesUp->getMinutes() - 1));
        }

        return $minutes;
    }
}
