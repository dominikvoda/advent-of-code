<?php declare(strict_types = 1);

namespace AdventOfCode;

final class ArrayCountResult implements Result
{
    /**
     * @var int
     */
    private $result;


    public function __construct(array $result)
    {
        $this->result = count($result);
    }


    public function toString(): string
    {
        return (string)$this->result;
    }
}
