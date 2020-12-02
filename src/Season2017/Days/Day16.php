<?php

namespace AdventOfCode\Season2017\Days;

class Day16 extends DefaultDay
{
    private const ARRAY_SIZE = 16;

    /**
     * @return string
     */
    protected function getInputType(): string
    {
        return self::INPUT_SIMPLE;
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveFirstPuzzle($input): string
    {
        $programs = $this->loadPrograms();
        $moves = $this->loadMoves($input);

        $this->dance($programs, $moves);

        $result = implode('', $programs['key_char']);

        return $result;
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $programs = $this->loadPrograms();
        $moves = $this->loadMoves($input);

        $this->dance($programs, $moves);
        $result = implode('', $programs['key_char']);
        $i = 0;
        $snapshots = [];
        while (!in_array($result, $snapshots)) {
            $snapshots[$i] = $result;
//            echo $i . ': ' . $result . PHP_EOL;
            $this->dance($programs, $moves);
            $result = implode('', $programs['key_char']);
            $i++;
        }

        $mod = bcmod(1000000000, $i);

        return $snapshots[$mod - 1];
    }

    /**
     * @param array $programs
     * @param array $moves
     */
    private function dance(array &$programs, array $moves): void
    {
        /** @var array $move */
        foreach ($moves as $move) {
            /** @var callable $callback */
            $callback = $move['callback'];
            $callback($move['input'], $programs);
        }
    }

    /**
     * @return array
     */
    private function loadPrograms(): array
    {
        $programs = [];
        for ($c = 'a', $i = 0; $c < 'q'; $c++, $i++) {
            $programs['key_char'][$i] = $c;
            $programs['key_char_tmp'][$i] = $c;
            $programs['char_key'][$c] = $i;
        }

        return $programs;
    }

    /**
     * @param string $input
     *
     * @return array
     */
    private function loadMoves(string $input): array
    {
        $moves = [];
        $explode = explode(',', $input);
        /** @var string $move */
        foreach ($explode as $move) {
            $type = $move[0];
            $input = substr($move, 1);

            if ($type === 's') {
                $moves[] = [
                    'input'    => [$input],
                    'callback' => [$this, 'spin'],
                ];
            }

            if ($type === 'x') {
                $moves[] = [
                    'input'    => explode('/', $input),
                    'callback' => [$this, 'exchange'],
                ];
            }

            if ($type === 'p') {
                $moves[] = [
                    'input'    => explode('/', $input),
                    'callback' => [$this, 'partner'],
                ];
            }
        }

        return $moves;
    }

    /**
     * @param array $input
     * @param array $programs
     */
    public function spin(array $input, array &$programs): void
    {
        foreach ($programs['key_char_tmp'] as $key => $char) {
            $newKey = ($input[0] + $key) % self::ARRAY_SIZE;
            $programs['key_char'][$newKey] = $char;
            $programs['char_key'][$char] = $newKey;
        }
        $programs['key_char_tmp'] = $programs['key_char'];
    }

    /**
     * @param array $input
     * @param array $programs
     */
    public function exchange(array $input, array &$programs): void
    {
        $aKey = $input[0];
        $bKey = $input[1];

        $aValue = $programs['key_char_tmp'][$bKey];
        $bValue = $programs['key_char_tmp'][$aKey];

        $programs['key_char'][$aKey] = $aValue;
        $programs['key_char'][$bKey] = $bValue;
        $programs['key_char_tmp'][$aKey] = $aValue;
        $programs['key_char_tmp'][$bKey] = $bValue;

        $programs['char_key'][$aValue] = $aKey;
        $programs['char_key'][$bValue] = $bKey;
    }

    /**
     * @param array $input
     * @param array $programs
     */
    public function partner(array $input, array &$programs): void
    {
        $aKey = $programs['char_key'][$input[0]];
        $bKey = $programs['char_key'][$input[1]];

        $aValue = $programs['key_char_tmp'][$bKey];
        $bValue = $programs['key_char_tmp'][$aKey];

        $programs['key_char'][$aKey] = $aValue;
        $programs['key_char'][$bKey] = $bValue;
        $programs['key_char_tmp'][$aKey] = $aValue;
        $programs['key_char_tmp'][$bKey] = $bValue;

        $programs['char_key'][$aValue] = $aKey;
        $programs['char_key'][$bValue] = $bKey;
    }
}
