<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day2;

use AdventOfCode\Season2020\LinesInput;
use AdventOfCode\Season2020\PuzzleSolution;
use function array_filter;
use function substr_count;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): string
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $passwordInputs = $input->mapLines(
            function (string $passwordInput): PasswordInput {
                return new PasswordInput($passwordInput);
            }
        );

        $validPasswords = array_filter(
            $passwordInputs,
            static function (PasswordInput $passwordInput): bool {
                $characterOccurrence = substr_count($passwordInput->getPassword(), $passwordInput->getCharacter());

                return $characterOccurrence >= $passwordInput->getMin()
                    && $characterOccurrence <= $passwordInput->getMax();
            }
        );

        return (string)count($validPasswords);
    }
}
