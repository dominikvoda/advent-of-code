<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Solutions\Day4;

class Guard
{
    /**
     * @var string
     */
    private $guardId;


    public function __construct(string $guardId)
    {
        $this->guardId = $guardId;
    }


    public function addRecord(string $record): void
    {
    }
}
