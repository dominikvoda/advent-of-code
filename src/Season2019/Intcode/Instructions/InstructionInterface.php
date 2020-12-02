<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Intcode\Instructions;

use AdventOfCode\Season2019\Intcode\InstructionPointer;
use Doctrine\Common\Collections\Collection;

interface InstructionInterface
{
    public const POSITION_MODE = 0;
    public const IMMEDIATE_MODE = 1;


    /**
     * @param Collection|int[] $program
     */
    public function execute(Collection $program, InstructionPointer $instructionPointer): void;


    public function getInstructionSize(): int;
}
