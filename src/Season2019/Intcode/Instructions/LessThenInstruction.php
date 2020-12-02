<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Intcode\Instructions;

use AdventOfCode\Season2019\Intcode\InstructionPointer;
use AdventOfCode\Season2019\Intcode\Opcode;
use AdventOfCode\Season2019\Intcode\Operand;
use Doctrine\Common\Collections\Collection;

class LessThenInstruction implements InstructionInterface
{
    /**
     * @var Opcode
     */
    private $opcode;


    public function __construct(Opcode $opcode)
    {
        $this->opcode = $opcode;
    }


    /**
     * @inheritDoc
     */
    public function execute(Collection $program, InstructionPointer $instructionPointer): void
    {
        $parameter3 = $program->get($this->opcode->getPosition() + 3);

        $operand1 = Operand::get($program, $this->opcode, 1);
        $operand2 = Operand::get($program, $this->opcode, 2);

        $result = $operand1 < $operand2;

        $program->set($parameter3, $result ? 1 : 0);
    }


    public function getInstructionSize(): int
    {
        return 4;
    }
}
