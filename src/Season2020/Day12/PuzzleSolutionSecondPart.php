<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day12;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function preg_match;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $commands = $input->mapLines(
            function (string $line): array {
                preg_match('/^(F|L|R|E|S|W|N)(\d+)$/', $line, $matches);

                return ['command' => $matches[1], 'distance' => (int)$matches[2]];
            }
        );

        $ship = new Ship();
        $waypoint = new Waypoint();

        foreach ($commands as $command) {
            if ($command['command'] === 'F') {
                $ship->moveToWaypoint($waypoint, $command['distance']);
                continue;
            }

            $waypoint->move($command['command'], $command['distance']);
        }

        return new IntegerResult($ship->getDistance());
    }
}
