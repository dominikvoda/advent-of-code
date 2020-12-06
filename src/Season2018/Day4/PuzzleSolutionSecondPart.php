<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day4;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_map;
use function array_product;
use function array_search;
use function array_shift;
use function asort;
use function explode;
use function max;
use function range;
use function rsort;
use function uasort;
use function usort;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    /**
     * @var int[]
     */
    private $minutes;


    public function getResult(): Result
    {
        /** @var Record[] $records */
        $records = LinesInput::createAsObjects(__DIR__ . '/input.txt', Record::class);

        usort(
            $records,
            static function (Record $recordA, Record $recordB): int {
                return $recordA->getCreatedAt() < $recordB->getCreatedAt() ? -1 : 1;
            }
        );

        $this->minutes = [];

        $firstRecord = array_shift($records);

        $currentGuardId = $firstRecord->getGuardId();

        while ($records !== []) {
            $currentRecord = array_shift($records);

            if ($currentRecord->isBeginsShift()) {
                $currentGuardId = $currentRecord->getGuardId();
            }

            if ($currentRecord->isFallsAsleep()) {
                $this->storeSleepingMinutes($currentGuardId, $currentRecord, array_shift($records));
            }
        }

        arsort($this->minutes);

        $topMinute = key($this->minutes);

        return new IntegerResult(array_product(explode(':', $topMinute)));
    }


    private function storeSleepingMinutes(int $guardId, Record $fallsAsleepRecord, Record $wakesUpRecord): void
    {
        $minutes = range($fallsAsleepRecord->getMinutes(), $wakesUpRecord->getMinutes() - 1);

        foreach ($minutes as $minute) {
            $key = $guardId . ':' . $minute;
            $this->minutes[$key] = ($this->minutes[$key] ?? 0) + 1;
        }
    }
}
