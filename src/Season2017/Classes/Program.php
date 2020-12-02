<?php

namespace AdventOfCode\Season2017\Classes;

class Program
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $childs;

    /**
     * @var int
     */
    private $weight;

    /**
     * @var Program|null
     */
    private $root;

    /**
     * @var Program[]
     */
    private $realChildrens = [];

    /**
     * @param string $input
     */
    public function __construct(string $input)
    {
        $this->name = $this->parseName($input);
        $this->weight = $this->parseWeight($input);
        $this->childs = $this->parseChilds($input);
        $this->root = null;
    }

    /**
     * @param string $input
     *
     * @return string
     */
    private function parseName(string $input): string
    {
        $parts = explode(' ', $input);

        return $parts[0];
    }

    /**
     * @param string $input
     *
     * @return int
     */
    private function parseWeight(string $input): int
    {
        preg_match("/\d+/", $input, $number);

        return $number[0];
    }

    /**
     * @param string $input
     *
     * @return array
     */
    private function parseChilds(string $input): array
    {
        $parts = explode(' -> ', $input);
        if (isset($parts[1])) {
            return explode(', ', $parts[1]);
        }

        return [];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getChilds(): array
    {
        return $this->childs;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasChild(string $name): bool
    {
        return in_array($name, $this->childs);
    }

    /**
     * @param Program $program
     */
    public function setRoot(Program $program): void
    {
        $this->root = $program;
    }

    /**
     * @param Program $program
     */
    public function addRealChildren(Program $program): void
    {
        $this->realChildrens[$program->getName()] = $program;
    }

    /**
     * @return bool
     */
    public function hasRoot(): bool
    {
        return $this->root !== null;
    }

    /**
     * @return int
     */
    public function getRealWeight(): int
    {
        $total = $this->weight;
        foreach ($this->realChildrens as $program) {
            $total += $program->getRealWeight();
        }

        return $total;
    }

    /**
     * @return array
     */
    public function getRealChildrens(): array
    {
        return $this->realChildrens;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @return int
     */
    public static function getInvalidWeightProgram(Program $program, int $expectedWeight = 0): int
    {
        $realChildrens = $program->realChildrens;

        if (count($realChildrens) === 0) {
            return $expectedWeight;
        }

        $childrensWeight = [];
        foreach ($realChildrens as $childrenProgram) {
            $childrensWeight[$childrenProgram->getName()] = $childrenProgram->getRealWeight();
        }

        $expectedValueAndInvalidChildren = self::getExpectedValueAndInvalidChildren($childrensWeight);

        $invalidName = $expectedValueAndInvalidChildren['invalid'];
        $expectedValue = $expectedValueAndInvalidChildren['expected'];

        if ($invalidName === null) {
            $diff = $program->getRealWeight() - $expectedWeight;

            return $program->getWeight() - $diff;
        }

        return self::getInvalidWeightProgram($realChildrens[$invalidName], $expectedValue);
    }

    /**
     * @param array $childrensWeight
     *
     * @return array
     */
    private static function getExpectedValueAndInvalidChildren(array $childrensWeight): array
    {
        $values = array_count_values($childrensWeight);
        $result = [];
        $result['invalid'] = null;
        foreach ($values as $value => $count) {
            if ($count === 1) {
                $result['invalid'] = array_search($value, $childrensWeight);
            } else {
                $result['expected'] = $value;
            }
        }

        return $result;
    }
}
