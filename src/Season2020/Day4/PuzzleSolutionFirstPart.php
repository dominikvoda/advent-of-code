<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day4;

use AdventOfCode\PuzzleSolution;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): string
    {
        $allCredentialsPasswords = AllCredentialsPasswordsResolver::resolve(__DIR__ . '/input.txt');

        return (string)count($allCredentialsPasswords);
    }
}
