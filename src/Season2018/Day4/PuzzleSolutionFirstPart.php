<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day4;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_count_values;
use function array_map;
use function array_merge;
use function array_search;
use function array_shift;
use function usort;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
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

        $guards = [];
        $guardRecords = [];

        $firstRecord = array_shift($records);

        $currentGuardId = $firstRecord->getGuardId();

        while ($records !== []) {
            $nextRecord = array_shift($records);

            if ($nextRecord->isBeginsShift()) {
                $guards[$currentGuardId][] = SleepingCounter::getSleepingMinutes($guardRecords);

                $currentGuardId = $nextRecord->getGuardId();
                $guardRecords = [];

                continue;
            }

            $guardRecords[] = $nextRecord;
        }

        $guards[$currentGuardId][] = SleepingCounter::getSleepingMinutes($guardRecords);

        $guardRecordsMerged = array_map(
            static function (array $guardMinutes): array {
                return array_merge(...$guardMinutes);
            },
            $guards
        );

        $guardRecordsCounted = array_map('count', $guardRecordsMerged);

        $guardId = array_search(max($guardRecordsCounted), $guardRecordsCounted, true);

        $minutesCount = array_count_values($guardRecordsMerged[$guardId]);
        $bestMinute = array_search(max($minutesCount), $minutesCount, true);

        return new IntegerResult($guardId * $bestMinute);
    }
}
