<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Day5;

use AdventOfCode\Season2019\Intcode\Computer;
use AdventOfCode\Season2019\Intcode\Input;
use AdventOfCode\Season2019\Intcode\Output;
use AdventOfCode\Season2019\PuzzleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use const PHP_EOL;

class Puzzle implements PuzzleInterface
{
    /**
     * @var Output
     */
    private $output;

    /**
     * @var Computer
     */
    private $computer;


    public function __construct()
    {
        $this->output = new Output();
        $this->computer = new Computer(new Input(5), $this->output);
    }


    public function resolveFirstPart(): string
    {
        $input = $this->loadInput();

        $this->runComputer($input);

        return $this->output->flush();
    }


    public function resolveSecondPart(): string
    {
        $input = $this->loadInput();

        $this->runComputer($input);

        return $this->output->flush();
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


    private function runComputer(Collection $input): int
    {
        /** @var int[]|Collection $integers */
        $integers = new ArrayCollection($input->toArray());

        return $this->computer->run($integers);
    }
}
