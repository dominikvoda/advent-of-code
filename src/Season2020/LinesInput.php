<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020;

use Nette\Utils\FileSystem;
use function array_map;
use function array_pop;
use function assert;
use function count;
use function explode;
use function is_array;
use function rtrim;
use const PHP_EOL;

final class LinesInput
{
    /**
     * @var string[]
     */
    private $lines;

    private $size;


    public function __construct(string $inputFile, string $delimiter = PHP_EOL)
    {
        $lines = explode($delimiter, rtrim(FileSystem::read($inputFile)));
        assert(is_array($lines));

        $this->lines = $lines;
        $this->size = count($this->lines);
    }


    /**
     * @return string[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }


    public function getSize(): int
    {
        return $this->size;
    }


    /**
     * @return int[]
     */
    public function getLinesAsNumbers(): array
    {
        return $this->mapLines(
            function (string $line): int {
                return (int)$line;
            }
        );
    }


    /**
     * @return mixed[]
     */
    public function mapLines(callable $callback): array
    {
        return array_map($callback, $this->lines);
    }
}
