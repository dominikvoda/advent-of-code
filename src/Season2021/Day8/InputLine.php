<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day8;

use Exception;
use function array_map;
use function array_search;
use function count;
use function explode;

final class InputLine
{
    /**
     * @var string[]
     */
    private array $outputs;

    /**
     * @var string[][]
     */
    private array $inputs;

    /**
     * @var int[]
     */
    private array $segmentUsage;


    public function __construct(string $input)
    {
        $parts = explode(' | ', $input);
        $this->outputs = explode(' ', $parts[1]);

        $this->inputs = array_map('str_split', explode(' ', $parts[0]));
        $this->segmentUsage = [
            'a' => 0,
            'b' => 0,
            'c' => 0,
            'd' => 0,
            'e' => 0,
            'f' => 0,
            'g' => 0,
        ];

        foreach ($this->inputs as $segments) {
            foreach ($segments as $segment) {
                $this->segmentUsage[$segment]++;
            }
        }
    }


    /**
     * @return string[]
     */
    public function getOutputs(): array
    {
        return $this->outputs;
    }


    /**
     * @return string[][]
     */
    public function getInputs(): array
    {
        return $this->inputs;
    }


    public function getSevenSegments(): array
    {
        return $this->getSpecificNumber(3);
    }


    public function getOneSegments(): array
    {
        return $this->getSpecificNumber(2);
    }


    public function getFourSegments(): array
    {
        return $this->getSpecificNumber(4);
    }


    private function getSpecificNumber(int $length): array
    {
        foreach ($this->getInputs() as $input) {
            if (count($input) === $length) {
                return $input;
            }
        }

        throw new Exception('Lame!!');
    }


    public function getBSegment(): string
    {
        return array_search(6, $this->segmentUsage, true);
    }


    public function getESegment(): string
    {
        return array_search(4, $this->segmentUsage, true);
    }


    public function getFSegment(): string
    {
        return array_search(9, $this->segmentUsage, true);
    }
}
