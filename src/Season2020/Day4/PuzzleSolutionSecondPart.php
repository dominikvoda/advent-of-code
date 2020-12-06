<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day4;

use AdventOfCode\ArrayCountResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_filter;
use function count;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $allCredentialsPasswords = AllCredentialsPasswordsResolver::resolve(__DIR__ . '/input.txt');

        $validPasswords = array_filter(
            $allCredentialsPasswords,
            static function (Passport $passport): bool {
                return $passport->isValid();
            }
        );

        return new ArrayCountResult($validPasswords);
    }
}
