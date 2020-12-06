<?php declare(strict_types = 1);

namespace AdventOfCode;

final class StringResult implements Result
{
    /**
     * @var string
     */
    private $result;


    public function __construct(string $result)
    {
        $this->result = $result;
    }


    public function toString(): string
    {
        return $this->result;
    }
}
