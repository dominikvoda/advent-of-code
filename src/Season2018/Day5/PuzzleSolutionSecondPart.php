<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day5;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use Nette\Utils\FileSystem;
use Nette\Utils\Strings;
use function array_map;
use function range;
use function str_replace;
use function strlen;
use function trim;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $polymer = trim(FileSystem::read(__DIR__ . '/input.txt'));

        $results = array_map(
            static function (string $unit) use ($polymer): int {
                $newPolymer = str_replace([$unit, Strings::upper($unit)], '', $polymer);

                return strlen(PolymerReactor::react($newPolymer));
            },
            range('a', 'z')
        );

        return IntegerResult::fromArrayMin($results);
    }
}
