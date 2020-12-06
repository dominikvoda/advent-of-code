<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day3;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;
use function array_count_values;
use function array_map;
use function array_merge;

final class PuzzleSolutionSecondPart implements PuzzleSolution
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

        foreach ($rectangles as $rectangle) {
            foreach ($rectangle->getCoordinates() as $coordinate) {
                if($countValues[$coordinate] > 1){
                    continue 2;
                }
            }

            return new IntegerResult($rectangle->getId());
        }

        throw new LogicException('Oh no!');
    }
}
