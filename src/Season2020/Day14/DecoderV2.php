<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day14;

use function array_filter;
use function array_keys;
use function array_pop;
use function bindec;
use function decbin;
use function implode;
use function in_array;
use function preg_match;
use function str_pad;
use function str_split;
use const STR_PAD_LEFT;

final class DecoderV2 implements Decoder
{
    /**
     * @var int[]
     */
    private $memory;

    /**
     * @var int[]
     */
    private $addressOffsets;

    /**
     * @var string[]
     */
    private $mask;


    public function __construct()
    {
        $this->memory = [];
        $this->addressOffsets = [];
        $this->mask = [];
    }


    public function storeInMemory(string $instruction): void
    {
        preg_match('/^mem\[(\d+)] = (\d+)$/', $instruction, $matches);

        $addressBin = str_pad(decbin((int)$matches[1]), 36, '0', STR_PAD_LEFT);
        $addressBits = str_split($addressBin);
        $persistedKeys = array_keys($this->mask, '0');

        foreach ($addressBits as $bit => $value) {
            if (in_array($bit, $persistedKeys, true)) {
                $addressBits[$bit] = $value;
                continue;
            }

            $addressBits[$bit] = '0';
        }

        $address = (int)bindec(implode('', $addressBits));

        foreach ($this->addressOffsets as $addressOffset) {
            $this->memory[$address + $addressOffset] = (int)$matches[2];
        }
    }


    public function changeMask(string $instruction): void
    {
        preg_match('/^mask \= ([01X]+)$/', $instruction, $matches);

        $mask = str_split($matches[1]);

        $this->mask = $mask;
        $this->addressOffsets = $this->getAddressOffsets($mask);
    }


    public function getMemory(): array
    {
        return $this->memory;
    }


    private function getAddressOffsets(array $mask): array
    {
        $countX = count($mask) - count(array_filter($mask, 'is_numeric'));
        $combinationsCount = 2 ** $countX;

        $addresses = [];

        for ($i = 0; $i < $combinationsCount; $i++) {
            $newMask = $mask;
            $replacement = str_split(str_pad(decbin($i), $countX, '0', STR_PAD_LEFT));

            foreach ($newMask as $key => $value) {
                if ($value === 'X') {
                    $newMask[$key] = array_pop($replacement);
                }
            }

            $addresses[] = (int)bindec(implode('', $newMask));
        }

        return $addresses;
    }
}
