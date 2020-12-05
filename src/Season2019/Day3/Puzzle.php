<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Day3;

use AdventOfCode\Season2019\Input;
use AdventOfCode\Season2019\PuzzleInterface;
use LogicException;
use Symfony\Component\Console\Output\OutputInterface;
use function abs;
use function array_intersect;
use function array_map;
use function explode;
use function min;
use function preg_match;

class Puzzle implements PuzzleInterface
{
    /**
     * @var OutputInterface
     */
    private $output;


    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }


    public function resolveFirstPart(): string
    {
        $lines = Input::linesFromFile(__DIR__ . '/input.txt');

        $lineA = $this->createLine($lines->first());
        $lineB = $this->createLine($lines->last());

        $intersections = $this->getAllIntersections($lineA, $lineB);

        $distances = array_map(
            static function (string $intersection): int {
                $coordinates = explode(':', $intersection);

                return (int)abs($coordinates[0] + (int)abs($coordinates[1]));
            },
            $intersections
        );

        return (string)min($distances);
    }


    public function resolveSecondPart(): string
    {
        $lines = Input::linesFromFile(__DIR__ . '/input.txt');

        $lineA = $this->createLine($lines->first());
        $lineB = $this->createLine($lines->last());

        $stepsA = $this->createSteps($lineA);
        $stepsB = $this->createSteps($lineB);

        $intersections = $this->getAllIntersections($lineA, $lineB);

        $totalSteps = array_map(
            static function (string $coordinate) use ($stepsA, $stepsB): int {
                return $stepsA[$coordinate] + $stepsB[$coordinate];
            },
            $intersections
        );

        return (string)min($totalSteps);
    }


    private function getInstructions(array $line): array
    {
        return array_map(
            function (string $command): array {
                return $this->getInstruction($command);
            },
            $line
        );
    }


    private function getInstruction(string $command): array
    {
        preg_match('/(L|R|U|D)(\d+)/', $command, $parsed);

        $steps = $parsed[2];
        $direction = $parsed[1];

        if ($direction === 'L') {
            return ['x' => -1, 'y' => 0, 'steps' => $steps];
        }

        if ($direction === 'R') {
            return ['x' => 1, 'y' => 0, 'steps' => $steps];
        }

        if ($direction === 'D') {
            return ['x' => 0, 'y' => 1, 'steps' => $steps];
        }

        if ($direction === 'U') {
            return ['x' => 0, 'y' => -1, 'steps' => $steps];
        }

        throw new LogicException('No way');
    }


    private function createLine(string $instructionsInput): array
    {
        $instructions = $this->getInstructions(Input::separatedBy($instructionsInput, ',')->toArray());

        $x = 0;
        $y = 0;

        $line = [];

        foreach ($instructions as $instruction) {
            for ($i = 0; $i < $instruction['steps']; $i++) {
                $x += $instruction['x'];
                $y += $instruction['y'];
                $line[] = $x . ':' . $y;
            }
        }

        return $line;
    }


    private function createSteps(array $line): array
    {
        $counter = 0;
        $steps = ['0:0' => $counter];

        foreach ($line as $coordinate) {
            $counter++;

            if (isset($steps[$coordinate])) {
                continue;
            }

            $steps[$coordinate] = $counter;
        }

        return $steps;
    }


    private function getAllIntersections(array $lineA, array $lineB): array
    {
        return array_intersect($lineA, $lineB);
    }
}
