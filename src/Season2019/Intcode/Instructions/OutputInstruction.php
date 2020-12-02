<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Intcode\Instructions;

use AdventOfCode\Season2019\Intcode\InstructionPointer;
use AdventOfCode\Season2019\Intcode\Opcode;
use AdventOfCode\Season2019\Intcode\Operand;
use AdventOfCode\Season2019\Intcode\Output;
use Doctrine\Common\Collections\Collection;

class OutputInstruction implements InstructionInterface
{
    /**
     * @var Opcode
     */
    private $opcode;

    /**
     * @var Output
     */
    private $output;


    public function __construct(Opcode $opcode, Output $output)
    {
        $this->opcode = $opcode;
        $this->output = $output;
    }


    /**
     * @inheritDoc
     */
    public function execute(Collection $program, InstructionPointer $instructionPointer): void
    {
        $operand1 = Operand::get($program, $this->opcode, 1);

        $this->output->write($operand1);
    }


    public function getInstructionSize(): int
    {
        return 2;
    }
}
