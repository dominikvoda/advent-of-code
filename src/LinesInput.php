<?php declare(strict_types = 1);

namespace AdventOfCode;

use Nette\Utils\FileSystem;
use function array_map;
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


    public static function createAsObjects(string $inputFile, string $objectClass, string $delimiter = PHP_EOL): array
    {
        $input = new self($inputFile, $delimiter);

        return $input->mapLines(
            function (string $passportCredentials) use ($objectClass) {
                return new $objectClass($passportCredentials);
            }
        );
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
        return array_map('intval', $this->lines);
    }


    /**
     * @param callable|string $callback
     *
     * @return array
     */
    public function mapLines($callback): array
    {
        return array_map($callback, $this->lines);
    }
}
