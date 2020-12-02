<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Intcode;

use Doctrine\Common\Collections\Collection;

class Computer
{
    /**
     * @var InstructionResolver
     */
    private $instructionResolver;

    /**
     * @var InstructionPointer
     */
    private $instructionPointer;


    public function __construct(?InputInterface $input = null, ?Output $output = null)
    {
        $this->instructionResolver = new InstructionResolver($input ?? new Input(), $output ?? new Output());
        $this->instructionPointer = new InstructionPointer(0);
    }


    public function run(Collection $program): int
    {
        while (true) {
            $instruction = $program->get($this->instructionPointer->getCurrentPosition());

            if ($instruction === 99) {
                break;
            }

            $instruction = $this->instructionResolver->resolve(
                $this->instructionPointer->getCurrentPosition(),
                $instruction
            );

            $instruction->execute($program, $this->instructionPointer);

            $this->instructionPointer->move($instruction->getInstructionSize());
        }

        return $program->get(0);
    }
}
