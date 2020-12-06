<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day5;

use Nette\Utils\Strings;
use function array_map;
use function array_merge;
use function assert;
use function is_string;
use function range;
use function str_replace;
use function strlen;

final class PolymerReactor
{
    public static function react(string $polymer): string
    {
        $replacePairs = array_merge(...array_map([PolymerReactor::class, 'createReplacePair'], range('a', 'z')));
        $length = strlen($polymer);

        while (true) {
            $newPolymer = str_replace($replacePairs, '', $polymer);
            assert(is_string($newPolymer));

            $newLength = strlen($newPolymer);

            if ($newLength === $length) {
                return $newPolymer;
            }

            $polymer = $newPolymer;
            $length = $newLength;
        }
    }


    public static function createReplacePair(string $char): array
    {
        $upper = Strings::upper($char);

        return [$char . $upper, $upper . $char];
    }
}
