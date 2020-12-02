<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Intcode;

class Instruction
{
    /**
     * @var int
     */
    private $position;

    /**
     * @var int
     */
    private $code;


    public function __construct(int $position, int $code)
    {
        $this->position = $position;
        $this->code = $code;
    }
}
