<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Intcode;

use AdventOfCode\Season2019\Intcode\Instructions\AddInstruction;
use AdventOfCode\Season2019\Intcode\Instructions\EqualsInstruction;
use AdventOfCode\Season2019\Intcode\Instructions\InputInstruction;
use AdventOfCode\Season2019\Intcode\Instructions\InstructionInterface;
use AdventOfCode\Season2019\Intcode\Instructions\JumpIfFalseInstruction;
use AdventOfCode\Season2019\Intcode\Instructions\JumpIfTrueInstruction;
use AdventOfCode\Season2019\Intcode\Instructions\LessThenInstruction;
use AdventOfCode\Season2019\Intcode\Instructions\MultiplyInstruction;
use AdventOfCode\Season2019\Intcode\Instructions\OutputInstruction;
use InvalidArgumentException;
use function str_pad;
use const STR_PAD_LEFT;

class InstructionResolver
{
    /**
     * @var Input
     */
    private $input;

    /**
     * @var Output
     */
    private $output;


    public function __construct(InputInterface $input, Output $output)
    {
        $this->input = $input;
        $this->output = $output;
    }


    public function resolve(int $position, int $input): InstructionInterface
    {
        $normalizedInput = str_pad((string)$input, 5, '0', STR_PAD_LEFT);

        $opcode = new Opcode($position, $normalizedInput);

        if ($opcode->getOpcode() === 1) {
            return new AddInstruction($opcode);
        }

        if ($opcode->getOpcode() === 2) {
            return new MultiplyInstruction($opcode);
        }

        if ($opcode->getOpcode() === 3) {
            return new InputInstruction($opcode, $this->input);
        }

        if ($opcode->getOpcode() === 4) {
            return new OutputInstruction($opcode, $this->output);
        }

        if ($opcode->getOpcode() === 5) {
            return new JumpIfTrueInstruction($opcode);
        }

        if ($opcode->getOpcode() === 6) {
            return new JumpIfFalseInstruction($opcode);
        }

        if ($opcode->getOpcode() === 7) {
            return new LessThenInstruction($opcode);
        }

        if ($opcode->getOpcode() === 8) {
            return new EqualsInstruction($opcode);
        }

        throw new InvalidArgumentException('Unknown instruction');
    }
}
