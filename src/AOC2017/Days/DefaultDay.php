<?php

namespace AOC2017\Days;

use Exception;

abstract class DefaultDay
{
    protected const INPUT_LINES = 'lines';
    protected const INPUT_SIMPLE = 'simple';
    protected const INPUT_NONE = 'none';
    protected const INPUT_DIRECT = 'direct';

    /**
     * @return string
     */
    protected abstract function getInputType(): string;

    /**
     * @param array|string|null $input
     *
     * @return string
     */
    protected function resolveFirstPuzzle($input): string
    {
        return 'not implemented yet';
    }

    /**
     * @param array|string|null $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        return 'not implemented yet';
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function getDirectInput(): string
    {
        throw new Exception('You should override this method for direct input');
    }

    /**
     * @param $input
     *
     * @return string
     */
    final public function getFirstResult($input): string
    {
        return $this->resolveFirstPuzzle($input);
    }

    /**
     * @param $input
     *
     * @return string
     */
    final public function getSecondResult($input): string
    {
        return $this->resolveSecondPuzzle($input);
    }

    /**
     * @param int $dayNumber
     *
     * @return  array|string|null $input
     * @throws Exception
     */
    final public function loadInput(int $dayNumber)
    {
        if ($this->getInputType() === self::INPUT_NONE) {
            return null;
        }

        if ($this->getInputType() === self::INPUT_SIMPLE) {
            return trim(file_get_contents($this->getInputPath($dayNumber)));
        }

        if ($this->getInputType() === self::INPUT_DIRECT) {
            return $this->getDirectInput();
        }

        return $this->loadLinesInput($dayNumber);
    }

    /**
     * @param int $dayNumber
     *
     * @return string
     */
    private function getInputPath(int $dayNumber): string
    {
        return sprintf('%s/../../../inputs/%s.txt', __DIR__, $dayNumber);
    }

    /**
     * @param int $dayNumber
     *
     * @return array
     */
    private function loadLinesInput(int $dayNumber): array
    {
        $lines = explode("\n", file_get_contents($this->getInputPath($dayNumber)));

        array_pop($lines);

        return $lines;
    }
}
