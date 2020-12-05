<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day4;

use AdventOfCode\LinesInput;
use function array_filter;
use const PHP_EOL;

final class AllCredentialsPasswordsResolver
{
    /**
     * @return Passport[]
     */
    public static function resolve(string $inputFile): array
    {
        $input = new LinesInput($inputFile, PHP_EOL . PHP_EOL);

        $passports = $input->mapLines(
            function (string $passportCredentials): Passport {
                return new Passport($passportCredentials);
            }
        );

        return array_filter(
            $passports,
            static function (Passport $passport): bool {
                return $passport->hasAllCredentials();
            }
        );
    }
}
