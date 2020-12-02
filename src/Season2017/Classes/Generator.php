<?php

namespace AdventOfCode\Season2017\Classes;

class Generator
{
    private const DIVIDE = 2147483647;

    /**
     * @var int
     */
    private $previous;

    /**
     * @var int
     */
    private $factor;

    /**
     * @param int $initValue
     * @param int $factor
     */
    public function __construct(int $initValue, int $factor)
    {
        $this->previous = $initValue;
        $this->factor = $factor;
    }

    /**
     * @param int|null $criteriaDivider
     *
     * @return string
     */
    public function getNextBinaryString(?int $criteriaDivider = null): string
    {
        $this->previous = $this->getNextNumber();

        if (null !== $criteriaDivider) {
            while (true) {
                if (bcmod($this->previous, $criteriaDivider) == 0) {
                    break;
                }
                $this->previous = $this->getNextNumber();
            }
        }

        $binaryString = decbin($this->previous);

        return substr($binaryString, -16);
    }

    /**
     * @return int
     */
    private function getNextNumber(): int
    {
        $nextNumber = $this->previous * $this->factor;

        return bcmod($nextNumber, self::DIVIDE);
    }
}
