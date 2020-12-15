<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day14;

interface Decoder
{
    public function storeInMemory(string $instruction): void;


    public function changeMask(string $instruction): void;


    public function getMemory(): array;
}
