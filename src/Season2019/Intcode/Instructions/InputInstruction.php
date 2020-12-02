<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Intcode\Instructions;

use AdventOfCode\Season2019\Intcode\Input;
use AdventOfCode\Season2019\Intcode\InputInterface;
use AdventOfCode\Season2019\Intcode\InstructionPointer;
use AdventOfCode\Season2019\Intcode\Opcode;
use Doctrine\Common\Collections\Collection;

class InputInstruction implements InstructionInterface
{
    /**
     * @var Opcode
     */
    private $opcode;

    /**
     * @var InputInterface
     */
    private $input;


    public function __construct(Opcode $opcode, InputInterface $input)
    {
        $this->opcode = $opcode;
        $this->input = $input;
    }


    /**
     * @inheritDoc
     */
    public function execute(Collection $program, InstructionPointer $instructionPointer): void
    {
        $parameter1 = $program->get($this->opcode->getPosition() + 1);

        $program->set($parameter1, $this->input->getValue());
    }


    public function getInstructionSize(): int
    {
        return 2;
    }
}
