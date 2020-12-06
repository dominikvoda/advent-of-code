<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day3;

use AdventOfCode\ArrayCountResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_count_values;
use function array_filter;
use function array_map;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        /** @var Rectangle[] $rectangles */
        $rectangles = LinesInput::createAsObjects(__DIR__ . '/input.txt', Rectangle::class);

        $allCoordinates = array_map(
            static function (Rectangle $rectangle): array {
                return $rectangle->getCoordinates();
            },
            $rectangles
        );

        $coordinates = array_merge(...$allCoordinates);
        $countValues = array_count_values($coordinates);

        $moreThanOnce = array_filter(
            $countValues,
            static function (int $count): bool {
                return $count > 1;
            }
        );


        return new ArrayCountResult($moreThanOnce);
    }
}
