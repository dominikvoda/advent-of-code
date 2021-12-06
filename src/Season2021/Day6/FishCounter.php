<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day6;

use function array_fill;
use function array_sum;

final class FishCounter
{
    public static function count(array $startFish, int $days): int
    {
        $timers = array_fill(0, 9, 0);
        foreach ($startFish as $timer) {
            $timers[$timer]++;
        }
        $currentTimers = $timers;
        $nextTimers = array_fill(0, 9, 0);

        for ($i = 0; $i < $days; $i++) {
            foreach ($currentTimers as $timer => $fishCount) {
                if ($timer === 0) {
                    $nextTimers[6] += $fishCount;
                    $nextTimers[8] += $fishCount;
                    continue;
                }

                $nextTimers[$timer-1] += $fishCount;
            }

            $currentTimers = $nextTimers;
            $nextTimers = array_fill(0, 9, 0);
        }

        return array_sum($currentTimers);
    }
}
