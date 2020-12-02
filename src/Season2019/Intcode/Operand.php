<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Intcode;

use AdventOfCode\Season2019\Intcode\Instructions\InstructionInterface;
use Doctrine\Common\Collections\Collection;

class Operand
{
    public static function get(Collection $program, Opcode $opcode, int $index): int
    {
        $parameter = $program->get($opcode->getPosition() + $index);

        return $opcode->getParameterMode($index) === InstructionInterface::POSITION_MODE
            ? $program->get($parameter)
            : $parameter;
    }
}
