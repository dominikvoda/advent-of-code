<?php declare(strict_types = 1);

namespace AdventOfCode;

use function array_sum;
use function max;

final class IntegerResult implements Result
{
    /**
     * @var int
     */
    private $result;


    public function __construct(int $result)
    {
        $this->result = $result;
    }


    public static function fromArrayCount(array $arrayToCount): self
    {
        return new self(count($arrayToCount));
    }


    public static function fromArraySum(array $arrayToSum): self
    {
        return new self(array_sum($arrayToSum));
    }


    public static function fromArrayMax(array $array): self
    {
        return new self(max($array));
    }


    public static function fromArrayMin(array $array): self
    {
        return new self(min($array));
    }


    public function toString(): string
    {
        return (string)$this->result;
    }
}
