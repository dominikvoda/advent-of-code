<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day5;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use Nette\Utils\FileSystem;
use function range;
use function strlen;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $polymer = trim(FileSystem::read(__DIR__ . '/input.txt'));

        $newPolymer = PolymerReactor::react($polymer, range('a', 'z'));

        return new IntegerResult(strlen($newPolymer));
    }
}
