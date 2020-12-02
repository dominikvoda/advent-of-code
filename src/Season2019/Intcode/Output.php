<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Intcode;

use function implode;

class Output
{
    /**
     * @var int[]
     */
    private $output;


    public function __construct()
    {
        $this->output = [];
    }


    public function write(int $value): void
    {
        $this->output[] = $value;
    }


    public function flush(): string
    {
        $output = implode('', $this->output);

        $this->output = [];

        return $output;
    }
}
