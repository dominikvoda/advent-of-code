<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day14;

use Nette\Utils\Strings;

final class Computer
{
    /**
     * @var Decoder
     */
    private $decoder;


    public function __construct(Decoder $decoder)
    {
        $this->decoder = $decoder;
    }


    public function run(string $instruction): void
    {
        if (Strings::startsWith($instruction, 'mask = ')) {
            $this->decoder->changeMask($instruction);

            return;
        }

        $this->decoder->storeInMemory($instruction);
    }
}
