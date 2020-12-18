<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day15;

use function array_flip;
use function count;
use function explode;

final class MemoryGame
{
    /**
     * @var int
     */
    private $rounds;


    public function __construct(int $rounds)
    {
        $this->rounds = $rounds;
    }


    public function play(string $startingNumbers): int
    {
        $input = explode(',', $startingNumbers);

        $numbers = array_flip($input);
        $startPointer = count($numbers);
        $lastRound = $this->rounds - 1;

        $nextNumber = 0;

        for ($pointer = $startPointer; $pointer < $lastRound; $pointer++) {
            $lastTime = $numbers[$nextNumber] ?? null;
            $numbers[$nextNumber] = $pointer;

            $nextNumber = $lastTime !== null ? $pointer - $lastTime : 0;
        }

        return $nextNumber;
    }
}
