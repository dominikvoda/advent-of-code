<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day14;

use function array_filter;
use function array_replace;
use function bindec;
use function decbin;
use function implode;
use function ksort;
use function preg_match;
use function str_pad;
use function str_split;
use const STR_PAD_LEFT;

final class DecoderV1 implements Decoder
{
    /**
     * @var int[]
     */
    private $memory;

    /**
     * @var int[]
     */
    private $mask;


    public function __construct()
    {
        $this->memory = [];
        $this->mask = [];
    }


    public function storeInMemory(string $instruction): void
    {
        preg_match('/^mem\[(\d+)] = (\d+)$/', $instruction, $matches);

        $binValue = str_pad((string)decbin((int)$matches[2]), 36, '0', STR_PAD_LEFT);
        $binValuesAsArray = str_split($binValue);

        $result = array_replace($this->mask + $binValuesAsArray);
        ksort($result);

        $this->memory[$matches[1]] = bindec(implode('', $result));
    }


    public function changeMask(string $instruction): void
    {
        preg_match('/^mask \= ([01X]+)$/', $instruction, $matches);

        $this->mask = array_filter(str_split($matches[1]), 'is_numeric');
    }


    public function getMemory(): array
    {
        return $this->memory;
    }
}
