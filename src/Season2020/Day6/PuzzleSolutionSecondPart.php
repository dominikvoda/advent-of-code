<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day6;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_map;
use const PHP_EOL;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        /** @var Group[] $groups */
        $groups = LinesInput::createAsObjects(__DIR__ . '/input.txt', Group::class, PHP_EOL . PHP_EOL);

        $yesAnswers = array_map(
            static function (Group $group): int {
                return $group->getYesAnswers();
            },
            $groups
        );

        return IntegerResult::fromSum($yesAnswers);
    }
}
