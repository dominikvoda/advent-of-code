<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Nette\Utils\FileSystem;
use function explode;
use const PHP_EOL;

class Input
{
    /**
     * @return Collection|string[]
     */
    public static function linesFromFile(string $filePath): Collection
    {
        $lines = self::separatedByFromFile($filePath, PHP_EOL);

        return $lines->filter(
            static function (string $value): bool {
                return $value !== '';
            }
        );
    }


    public static function separatedByFromFile(string $filePath, string $delimiter): Collection
    {
        $inputFile = FileSystem::read($filePath);

        return self::separatedBy($inputFile, $delimiter);
    }


    public static function separatedBy(string $input, string $delimiter): Collection
    {
        return new ArrayCollection(explode($delimiter, $input));
    }
}
