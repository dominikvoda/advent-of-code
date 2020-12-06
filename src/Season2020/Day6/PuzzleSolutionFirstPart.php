<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day6;

use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use function array_map;
use function array_sum;
use const PHP_EOL;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): string
    {
        /** @var Group[] $groups */
        $groups = LinesInput::createAsObjects(__DIR__ . '/input.txt', Group::class, PHP_EOL . PHP_EOL);

        $answers = array_map(
            static function (Group $group): int {
                return $group->getCombinedAnswersCount();
            },
            $groups
        );

        return (string)array_sum($answers);
    }
}
