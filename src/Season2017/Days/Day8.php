<?php

namespace AdventOfCode\Season2017\Days;

use Exception;

class Day8 extends DefaultDay
{
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
     * @throws Exception
     */
    protected function resolveFirstPuzzle($input): string
    {
        $registers = [];
        /** @var string $line */
        foreach ($input as $line) {
            $parts = explode(' if ', $line);
            $conditionParts = $parts[1];
            $operationParts = $parts[0];

            if ($this->isReadyToJump($conditionParts, $registers)) {
                continue;
            }

            $this->processOperation($operationParts, $registers);
        }

        return max($registers);
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     * @throws Exception
     */
    protected function resolveSecondPuzzle($input): string
    {
        $max = 0;
        $registers = [];
        /** @var string $line */
        foreach ($input as $line) {
            $parts = explode(' if ', $line);
            $conditionParts = $parts[1];
            $operationParts = $parts[0];

            if ($this->isReadyToJump($conditionParts, $registers)) {
                continue;
            }

            $this->processOperation($operationParts, $registers);

            $newMax = max($registers);

            if ($newMax > $max) {
                $max = $newMax;
            }
        }

        return $max;
    }

    /**
     * @param string $operationParts
     * @param array  $registers
     */
    private function processOperation(string $operationParts, array &$registers): void
    {
        $parts = explode(' ', $operationParts);
        $registerKey = $parts[0];
        $operation = $parts[1];
        $addValue = $parts[2];

        if ($operation === 'inc') {
            $this->updateRegisterValue($registers, $registerKey, +$addValue);
        }

        if ($operation === 'dec') {
            $this->updateRegisterValue($registers, $registerKey, -$addValue);
        }
    }

    /**
     * @param array  $registers
     * @param string $registerKey
     * @param int    $addValue
     */
    private function updateRegisterValue(array &$registers, string $registerKey, int $addValue): void
    {
        $newValue = $this->getRegisterValue($registers, $registerKey) + $addValue;
        $registers[$registerKey] = $newValue;
    }

    /**
     * @param array  $registers
     * @param string $registerKey
     *
     * @return int
     */
    private function getRegisterValue(array &$registers, string $registerKey): int
    {
        if (array_key_exists($registerKey, $registers)) {
            return $registers[$registerKey];
        }

        $registers[$registerKey] = 0;

        return $this->getRegisterValue($registers, $registerKey);
    }

    /**
     * @param string $conditionParts
     * @param array  $registers
     *
     * @return bool
     * @throws Exception
     */
    private function isReadyToJump(string $conditionParts, array $registers): bool
    {
        $parts = explode(' ', $conditionParts);
        $registerKey = $parts[0];

        return !$this->getConditionResult($this->getRegisterValue($registers, $registerKey), $parts[2], $parts[1]);
    }

    /**
     * @param int    $operand1
     * @param int    $operand2
     * @param string $conditionType
     *
     * @return bool
     * @throws Exception
     */
    private function getConditionResult(int $operand1, int $operand2, string $conditionType): bool
    {
        if ($conditionType === '>') {
            return $operand1 > $operand2;
        }

        if ($conditionType === '<') {
            return $operand1 < $operand2;
        }

        if ($conditionType === '>=') {
            return $operand1 >= $operand2;
        }

        if ($conditionType === '<=') {
            return $operand1 <= $operand2;
        }

        if ($conditionType === '!=') {
            return $operand1 != $operand2;
        }

        if ($conditionType === '==') {
            return $operand1 == $operand2;
        }

        throw new Exception(sprintf('Unknown condition %s', $conditionType));
    }
}
