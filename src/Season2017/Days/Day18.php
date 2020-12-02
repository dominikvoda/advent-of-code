<?php

namespace AdventOfCode\Season2017\Days;

use AdventOfCode\Season2017\Classes\SoundProgram;

class Day18 extends DefaultDay
{
    /**
     * @var int
     */
    private $lastPlayed;

    public function __construct()
    {
        $this->lastPlayed = 0;
    }

    /**
     * @return string
     */
    protected function getInputType(): string
    {
        return self::INPUT_LINES;
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveFirstPuzzle($input): string
    {
        $registers = [];
        $instructions = $this->loadInstructions($input);
        $count = count($instructions);
        $pointer = 0;

        while ($pointer < $count) {
            $instruction = $instructions[$pointer];
            /** @var callable $callback */
            $callback = $instruction['callback'];
            $result = $callback($registers, $instruction['x'], $instruction['y']);

            if ($instruction['instruction'] === 'jgz' && $result !== 0) {
                $pointer += $result;
                continue;
            }

            if ($instruction['instruction'] === 'rcv' && $result !== 0) {
                return $result;
            }

            $pointer++;
        }

        return 'not found';
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $program0 = new SoundProgram(0, $input);
        $program1 = new SoundProgram(1, $input);

        while (!$program0->isLocked() || !$program1->isLocked()) {
            $program0->process($program1);
            $program1->process($program0);
        }

        return $program1->getSended();
    }

    /**
     * @param array  $registers
     * @param string $x
     * @param string $y
     *
     * @return int
     */
    public function set(array &$registers, string $x, string $y): int
    {
        $yValue = array_key_exists($y, $registers) ? $registers[$y] : $y;
        $registers[$x] = $yValue;

        return 0;
    }

    /**
     * @param array  $registers
     * @param string $x
     * @param string $y
     *
     * @return int
     */
    public function add(array &$registers, string $x, string $y): int
    {
        $y = array_key_exists($y, $registers) ? $registers[$y] : $y;
        $this->createIfNotExist($registers, $x);
        $registers[$x] += $y;

        return 0;
    }

    /**
     * @param array  $registers
     * @param string $x
     * @param string $y
     *
     * @return int
     */
    public function mul(array &$registers, string $x, string $y): int
    {
        $y = array_key_exists($y, $registers) ? $registers[$y] : $y;
        $this->createIfNotExist($registers, $x);
        $registers[$x] *= $y;

        return 0;
    }

    /**
     * @param array  $registers
     * @param string $x
     * @param string $y
     *
     * @return int
     */
    public function mod(array &$registers, string $x, string $y): int
    {
        $y = array_key_exists($y, $registers) ? $registers[$y] : $y;
        $this->createIfNotExist($registers, $x);
        $registers[$x] %= $y;

        return 0;
    }

    /**
     * @param array  $registers
     * @param string $x
     * @param string $y
     *
     * @return int
     */
    public function jgz(array &$registers, string $x, string $y): int
    {
        $xValue = array_key_exists($x, $registers) ? $registers[$x] : $x;
        if ($xValue <= 0) {
            return 0;
        }
        $yValue = array_key_exists($y, $registers) ? $registers[$y] : $y;

        return $yValue;
    }

    /**
     * @param array  $registers
     * @param string $x
     * @param string $y
     *
     * @return int
     */
    public function rcv(array &$registers, string $x, string $y): int
    {
        $xValue = $registers[$x];
        if ($xValue != 0) {
            return $this->lastPlayed;
        }

        return 0;
    }

    /**
     * @param array  $registers
     * @param string $x
     * @param string $y
     *
     * @return int
     */
    public function snd(array &$registers, string $x, string $y): int
    {
        $this->lastPlayed = $registers[$x];

        return 0;
    }

    /**
     * @param array $input
     *
     * @return array
     */
    private function loadInstructions(array $input): array
    {
        $instructions = [];
        /** @var string $value */
        foreach ($input as $value) {
            $parts = explode(' ', $value);
            $instruction = [
                'callback'    => $this->resolveInstructionCallback($parts[0]),
                'x'           => $parts[1],
                'y'           => '',
                'instruction' => $parts[0],
            ];
            if (isset($parts[2])) {
                $instruction['y'] = $parts[2];
            }
            $instructions[] = $instruction;
        }

        return $instructions;
    }

    /**
     * @param string $instruction
     *
     * @return callable
     */
    private function resolveInstructionCallback(string $instruction): callable
    {
        return [$this, $instruction];
    }

    /**
     * @param array  $registers
     * @param string $key
     */
    private function createIfNotExist(array &$registers, string $key): void
    {
        if (!array_key_exists($key, $registers)) {
            $registers[$key] = 0;
        }
    }
}
