<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day4;

use AdventOfCode\ArrayCountResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $allCredentialsPasswords = AllCredentialsPasswordsResolver::resolve(__DIR__ . '/input.txt');

        return new ArrayCountResult($allCredentialsPasswords);
    }
}
