<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Intcode;

class Input implements InputInterface
{
    /**
     * @var int
     */
    private $value;


    public function __construct(int $value = 0)
    {
        $this->value = $value;
    }


    public function getValue(): int
    {
        return $this->value;
    }


    public function setValue(int $value): void
    {
        $this->value = $value;
    }
}
