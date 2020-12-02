<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Intcode;

use function sprintf;

class Opcode
{
    /**
     * @var int
     */
    private $position;

    /**
     * @var int
     */
    private $opcode;

    /**
     * @var int
     */
    private $parameter1Mode;

    /**
     * @var int
     */
    private $parameter2Mode;

    /**
     * @var int
     */
    private $parameter3Mode;


    public function __construct(int $position, string $normalizedInput)
    {
        $this->position = $position;
        $this->opcode = (int)sprintf('%s%s', $normalizedInput[3], $normalizedInput[4]);
        $this->parameter1Mode = (int)$normalizedInput[2];
        $this->parameter2Mode = (int)$normalizedInput[1];
        $this->parameter3Mode = (int)$normalizedInput[0];
    }


    public function getPosition(): int
    {
        return $this->position;
    }


    public function getOpcode(): int
    {
        return $this->opcode;
    }


    public function getParameterMode(int $parameter): int
    {
        $parameterName = 'parameter' . $parameter . 'Mode';

        return $this->$parameterName;
    }


    public function getParameter1Mode(): int
    {
        return $this->parameter1Mode;
    }


    public function getParameter2Mode(): int
    {
        return $this->parameter2Mode;
    }


    public function getParameter3Mode(): int
    {
        return $this->parameter3Mode;
    }
}
