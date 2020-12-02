<?php

namespace AdventOfCode\Season2017\Classes;

class ExperimentalCoprocessor
{
    /**
     * @var
     */
    private $registers;

    /**
     * @var
     */
    private $instructions;

    /**
     * @var int
     */
    private $pointer;

    /**
     * @var
     */
    private $instructionCounter;

    /**
     * @var int
     */
    private $mulCounter;

    /**
     * @param array $input
     */
    public function __construct(array $input)
    {
        $this->pointer = 0;
        $this->registers = $this->loadRegisters();
        $this->instructions = $this->loadInstructions($input);
        $this->mulCounter = 0;
    }

    public function run(): void
    {
        $pointers = [];
        for ($i = 0; $i < $this->instructionCounter; $i++) {
            $pointers[$i] = 0;
        }

        $i = 0;
        while ($this->pointer < $this->instructionCounter) {
            $instruction = $this->instructions[$this->pointer];
            $callback = $instruction['callback'];
            $pointers[$this->pointer]++;
            $callback($instruction['registerKey'], $instruction['y']);

            if ($i % 100 === 0) {
                for ($i = 0; $i < $this->instructionCounter; $i++) {
                    echo sprintf('%s => %d%s', $i, $pointers[$i], PHP_EOL);
                }
            }
            $i++;
        }
    }

    /**
     * @return array
     */
    private function loadRegisters(): array
    {
        $registers = [];
        for ($i = 'a'; $i < 'i'; $i++) {
            $registers[$i] = 0;
        }

        return $registers;
    }

    /**
     * @param array $input
     *
     * @return array
     */
    private function loadInstructions(array $input): array
    {
        $instructions = [];
        /** @var string $row */
        foreach ($input as $row) {
            $parts = explode(' ', $row);

            $instruction = [
                'registerKey' => $parts[1],
                'y'           => $parts[2],
                'callback'    => [$this, $parts[0]],
            ];

            $instructions[] = $instruction;

            $this->instructionCounter++;
        }

        return $instructions;
    }

    /**
     * @param string $registerKey
     * @param        $y
     */
    public function set(string $registerKey, $y): void
    {
        $this->registers[$registerKey] = $this->getRegisterValueIfExist($y);
        $this->pointer++;
    }

    /**
     * @param string $registerKey
     * @param        $y
     */
    public function mul(string $registerKey, $y): void
    {
        $this->registers[$registerKey] *= $this->getRegisterValueIfExist($y);
        $this->pointer++;
        $this->mulCounter++;
    }

    /**
     * @param string $registerKey
     * @param        $y
     */
    public function jnz(string $registerKey, $y): void
    {
        $value = $this->getRegisterValueIfExist($registerKey);
        if ($value != 0) {
            $this->pointer += $y;
        } else {
            $this->pointer++;
        }
    }

    /**
     * @param string $registerKey
     * @param        $y
     */
    public function sub(string $registerKey, $y): void
    {
        $this->registers[$registerKey] -= $this->getRegisterValueIfExist($y);
        $this->pointer++;
    }

    /**
     * @param $key
     *
     * @return int
     */
    private function getRegisterValueIfExist($key): int
    {
        if (array_key_exists($key, $this->registers)) {
            return $this->registers[$key];
        }

        return $key;
    }

    /**
     * @return int
     */
    public function getMulCounter(): int
    {
        return $this->mulCounter;
    }

    /**
     * @param string $registerKey
     * @param int    $value
     */
    public function setRegisterValue(string $registerKey, int $value): void
    {
        $this->registers[$registerKey] = $value;
    }

    /**
     * @param string $registerKey
     *
     * @return int
     */
    public function getRegisterValue(string $registerKey): int
    {
        return $this->registers[$registerKey];
    }
}
