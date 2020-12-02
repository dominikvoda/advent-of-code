<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Intcode;

class InstructionPointer
{
    /**
     * @var int
     */
    private $currentPosition;


    public function __construct(int $startPosition)
    {
        $this->currentPosition = $startPosition;
    }


    public function move(int $positions): void
    {
        $this->currentPosition += $positions;
    }


    public function setPosition(int $position): void
    {
        $this->currentPosition = $position;
    }


    public function getCurrentPosition(): int
    {
        return $this->currentPosition;
    }
}
