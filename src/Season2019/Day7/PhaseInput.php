<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Day7;

use AdventOfCode\Season2019\Intcode\InputInterface;

class PhaseInput implements InputInterface
{
    /**
     * @var int
     */
    private $phase;

    /**
     * @var int
     */
    private $previousOutput;

    /**
     * @var bool
     */
    private $phaseReaded;


    public function __construct(int $phase, int $previousOutput)
    {
        $this->phase = $phase;
        $this->previousOutput = $previousOutput;
        $this->phaseReaded = false;
    }


    public function getValue(): int
    {
        if (!$this->phaseReaded) {
            $this->phaseReaded = true;

            return $this->phase;
        }

        return $this->previousOutput;
    }
}
