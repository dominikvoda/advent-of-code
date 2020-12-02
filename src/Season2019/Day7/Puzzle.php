<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Day7;

use AdventOfCode\Season2019\Input;
use AdventOfCode\Season2019\Intcode\Computer;
use AdventOfCode\Season2019\Intcode\Output;
use AdventOfCode\Season2019\PuzzleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use function array_map;
use function str_split;

class Puzzle implements PuzzleInterface
{
    public function resolveFirstPart(): string
    {
        $combinations = Input::linesFromFile(__DIR__ . '/combinations.txt')->map(
            static function (string $input): array {
                return array_map(
                    static function (string $char): int {
                        return (int)$char;
                    },
                    str_split($input)
                );
            }
        );
        $numbers = $this->loadInput();

        $max = 0;

        foreach ($combinations as $combination) {
            $thrust = $this->getThrust($numbers, $combination);

            if ($thrust > $max) {
                $max = $thrust;
            }
        }

        return (string)$max;
    }


    public function resolveSecondPart(): string
    {
    }


    private function getThrust(Collection $numbers, array $combination): string
    {
        $output = new Output();

        foreach ($combination as $value) {
            $input = new PhaseInput($value, $newOutput ?? 0);
            $computer = new Computer($input, $output);

            $computer->run(new ArrayCollection($numbers->toArray()));

            $newOutput = (int)$output->flush();
        }

        return (string)$newOutput;
    }


    private function loadInput(): Collection
    {
        return \AdventOfCode\Season2019\Input::separatedByFromFile(__DIR__ . '/input.txt', ',')
            ->map(
                static function (string $integer): int {
                    return (int)$integer;
                }
            );
    }
}
