<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Day4;

use AdventOfCode\Season2019\PuzzleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use function range;

class Puzzle implements PuzzleInterface
{
    public function resolveFirstPart(): string
    {
        $numbers = new ArrayCollection(range(246515, 739105));

        $passwords = $numbers
            ->map(
                static function (int $number): NumberInput {
                    return new NumberInput($number);
                }
            )
            ->filter(
                static function (NumberInput $numberInput): bool {
                    return $numberInput->hasDouble() && $numberInput->isNotDecreasing();
                }
            );

        return (string)$passwords->count();
    }


    public function resolveSecondPart(): string
    {
        $numbers = new ArrayCollection(range(246515, 739105));

        $passwords = $numbers
            ->map(
                static function (int $number): NumberInput {
                    return new NumberInput($number);
                }
            )
            ->filter(
                static function (NumberInput $numberInput): bool {
                    return $numberInput->hasDouble()
                        && $numberInput->isNotDecreasing()
                        && $numberInput->hasOneDouble();
                }
            );

        return (string)$passwords->count();
    }
}
