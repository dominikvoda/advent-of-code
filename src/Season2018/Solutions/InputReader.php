<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Solutions;

use function array_filter;
use function explode;
use const PHP_EOL;

class InputReader
{
    /**
     * @return string[]
     */
    public static function readAsLines(string $input): array
    {
        $exploded = self::readExploded(PHP_EOL, $input);

        return array_filter(
            $exploded,
            function (string $inputLine) {
                return $inputLine !== '';
            }
        );
    }


    public static function readExploded(string $delimiter, string $input): array
    {
        return explode($delimiter, $input);
    }
}
