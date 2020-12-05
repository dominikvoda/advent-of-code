<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day2;

use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use function array_filter;

final class PuzzleSolutionSecondPart implements PuzzleSolution
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
                $character = $passwordInput->getCharacter();

                $occurrences = 0;

                if ($passwordInput->getPassword()[$passwordInput->getMin() - 1] === $character) {
                    $occurrences++;
                }

                if ($passwordInput->getPassword()[$passwordInput->getMax() - 1] === $character) {
                    $occurrences++;
                }

                return $occurrences === 1;
            }
        );

        return (string)count($validPasswords);
    }
}
