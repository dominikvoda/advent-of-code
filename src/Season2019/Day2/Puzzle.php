<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Day2;

use AdventOfCode\Season2019\Input;
use AdventOfCode\Season2019\Intcode\Computer;
use AdventOfCode\Season2019\Intcode\InstructionResolver;
use AdventOfCode\Season2019\PuzzleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle implements PuzzleInterface
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var Computer
     */
    private $computer;


    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
        $this->computer = new Computer();
    }


    public function resolveFirstPart(): string
    {
        $input = $this->loadInput();

        $output = $this->getOutput($input, 12, 2);

        return (string)$output;
    }


    public function resolveSecondPart(): string
    {
        $input = $this->loadInput();

        for ($i = 0; $i < 100; $i++) {
            for ($j = 0; $j < 100; $j++) {
                $output = $this->getOutput($input, $i, $j);

                if ($output === 19690720) {
                    return (string)($i * 100 + $j);
                }
            }
        }

        return 'error';
    }


    private function loadInput(): Collection
    {
        return Input::separatedByFromFile(__DIR__ . '/input.txt', ',')
            ->map(
                static function (string $integer): int {
                    return (int)$integer;
                }
            );
    }


    private function getOutput(Collection $input, int $noun, int $verb): int
    {
        /** @var int[]|Collection $integers */
        $integers = new ArrayCollection($input->toArray());

        $integers->set(1, $noun);
        $integers->set(2, $verb);

        return $this->computer->run($integers);
    }
}
