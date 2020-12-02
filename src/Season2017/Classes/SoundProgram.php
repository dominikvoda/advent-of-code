<?php

namespace AdventOfCode\Season2017\Classes;

class SoundProgram
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var array
     */
    private $queue;

    /**
     * @var int
     */
    private $sended;

    /**
     * @var bool
     */
    private $locked;

    /**
     * @var array
     */
    private $instructions;

    /**
     * @var int
     */
    private $pointer;

    /**
     * @var array
     */
    private $registers;

    /**
     * @param int   $id
     * @param array $input
     */
    public function __construct(int $id, array $input)
    {
        $this->id = $id;
        $this->queue = [];
        $this->sended = 0;
        $this->locked = false;
        $this->instructions = $this->loadInstructions($input);
        $this->pointer = 0;
        $this->registers = [];
    }

    /**
     * @param array             $registers
     * @param string            $x
     * @param string            $y
     * @param SoundProgram|null $otherProgram
     *
     * @return int
     */
    public function set(array &$registers, string $x, string $y, SoundProgram $otherProgram = null): int
    {
        $yValue = array_key_exists($y, $registers) ? $registers[$y] : $y;
        $registers[$x] = $yValue;

        return 0;
    }

    /**
     * @param array             $registers
     * @param string            $x
     * @param string            $y
     * @param SoundProgram|null $otherProgram
     *
     * @return int
     */
    public function add(array &$registers, string $x, string $y, SoundProgram $otherProgram = null): int
    {
        $y = array_key_exists($y, $registers) ? $registers[$y] : $y;
        $this->createIfNotExist($registers, $x);
        $registers[$x] += $y;

        return 0;
    }

    /**
     * @param array             $registers
     * @param string            $x
     * @param string            $y
     * @param SoundProgram|null $otherProgram
     *
     * @return int
     */
    public function mul(array &$registers, string $x, string $y, SoundProgram $otherProgram = null): int
    {
        $y = array_key_exists($y, $registers) ? $registers[$y] : $y;
        $this->createIfNotExist($registers, $x);
        $registers[$x] *= $y;

        return 0;
    }

    /**
     * @param array             $registers
     * @param string            $x
     * @param string            $y
     * @param SoundProgram|null $otherProgram
     *
     * @return int
     */
    public function mod(array &$registers, string $x, string $y, SoundProgram $otherProgram = null): int
    {
        $y = array_key_exists($y, $registers) ? $registers[$y] : $y;
        $this->createIfNotExist($registers, $x);
        $registers[$x] %= $y;

        return 0;
    }

    /**
     * @param array             $registers
     * @param string            $x
     * @param string            $y
     * @param SoundProgram|null $otherProgram
     *
     * @return int
     */
    public function jgz(array &$registers, string $x, string $y, SoundProgram $otherProgram = null): int
    {
        $xValue = array_key_exists($x, $registers) ? $registers[$x] : $x;
        if ($xValue <= 0) {
            return 0;
        }
        $yValue = array_key_exists($y, $registers) ? $registers[$y] : $y;

        return $yValue;
    }

    /**
     * @param array             $registers
     * @param string            $x
     * @param string            $y
     * @param SoundProgram|null $otherProgram
     *
     * @return int
     */
    public function rcv(array &$registers, string $x, string $y, SoundProgram $otherProgram = null): int
    {
        $count = count($this->queue);

        if ($count !== 0) {
            $keys = array_keys($this->queue);
            $value = $this->queue[$keys[0]];
            unset($this->queue[$keys[0]]);
            $registers[$x] = $value;

            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @param array             $registers
     * @param string            $x
     * @param string            $y
     * @param SoundProgram|null $otherProgram
     *
     * @return int
     */
    public function snd(array &$registers, string $x, string $y, SoundProgram $otherProgram = null): int
    {
        if ($x >= 'a' && $x <= 'z') {
            $this->createIfNotExist($registers, $x);
        }
        $xValue = array_key_exists($x, $registers) ? $registers[$x] : $x;

        $otherProgram->pushToQueue($xValue);
        $this->sended++;

        return 0;
    }

    /**
     * @param array  $registers
     * @param string $key
     */
    private function createIfNotExist(array &$registers, string $key): void
    {
        if (!array_key_exists($key, $registers)) {
            $registers[$key] = $this->id;
        }
    }

    /**
     * @param int $value
     */
    public function pushToQueue(int $value): void
    {
        $this->queue[] = $value;
    }

    /**
     * @return int
     */
    public function getSended(): int
    {
        return $this->sended;
    }

    /**
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->locked;
    }

    /**
     * @param SoundProgram $otherProgram
     */
    public function process(SoundProgram $otherProgram): void
    {
        $instruction = $this->instructions[$this->pointer];
        /** @var callable $callback */
        $callback = $instruction['callback'];
        $result = $callback($this->registers, $instruction['x'], $instruction['y'], $otherProgram);

        if ($instruction['instruction'] === 'rcv' && $result === 0) {
            $this->locked = true;

            return;
        }

        if ($instruction['instruction'] === 'jgz' && $result !== 0) {
            $this->pointer += $result;
        } else {
            $this->pointer++;
        }
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
}
