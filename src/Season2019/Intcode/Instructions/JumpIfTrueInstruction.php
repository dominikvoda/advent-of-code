<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Intcode\Instructions;

use AdventOfCode\Season2019\Intcode\InstructionPointer;
use AdventOfCode\Season2019\Intcode\Opcode;
use AdventOfCode\Season2019\Intcode\Operand;
use Doctrine\Common\Collections\Collection;

class JumpIfTrueInstruction implements InstructionInterface
{
    /**
     * @var Opcode
     */
    private $opcode;

    /**
     * @var int
     */
    private $instructionSize;


    public function __construct(Opcode $opcode)
    {
        $this->opcode = $opcode;
        $this->instructionSize = 3;
    }


    /**
     * @inheritDoc
     */
    public function execute(Collection $program, InstructionPointer $instructionPointer): void
    {
        $operand1 = Operand::get($program, $this->opcode, 1);

        if ($operand1 !== 0) {
            $operand2 = Operand::get($program, $this->opcode, 2);

            $instructionPointer->setPosition($operand2);
            $this->instructionSize = 0;
        }
    }


    public function getInstructionSize(): int
    {
        return $this->instructionSize;
    }
}
