<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day12;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_filter;
use function explode;
use function in_array;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    /**
     * @var Cave[]
     */
    private array $caves;

    /**
     * @var string[]
     */
    private array $paths;


    public function __construct()
    {
        $this->caves = [];
        $this->paths = [];
        $lines = new LinesInput(__DIR__ . '/input.txt');

        foreach ($lines->getLines() as $line) {
            $parts = explode('-', $line);

            $this->addCave($parts[0], $parts[1]);
            $this->addCave($parts[1], $parts[0]);
        }
    }


    private function getCave(string $name): Cave
    {
        if (isset($this->caves[$name])) {
            return $this->caves[$name];
        }

        $newCave = new Cave($name, null);
        $this->caves[$name] = $newCave;

        return $newCave;
    }


    private function addCave(string $name, string $connection): void
    {
        $cave = $this->getCave($name);
        $cave->addConnection($this->getCave($connection));
    }


    public function getResult(): Result
    {
        $starts = array_filter($this->caves, static function (Cave $cave): bool {
            return $cave->isStart();
        });

        foreach ($starts as $start) {
            foreach ($start->getConnections() as $startConnection) {
                $this->findPath($startConnection, 'start', ['start']);
            }
        }

        return IntegerResult::fromArrayCount($this->paths);
    }


    private function findPath(Cave $cave, string $path, array $visitedOnce = [], bool $visitedTwice = false): void
    {
        if($cave->isStart()){
            return;
        }

        $newPath = $path . ',' . $cave->getName();
        if ($cave->isEnd()) {
            $this->paths[] = $newPath;

            return;
        }

        if ($cave->isSmall() && in_array($cave->getName(), $visitedOnce, true) && $visitedTwice) {
            return;
        }

        if ($cave->isSmall() && in_array($cave->getName(), $visitedOnce, true)) {
            $visitedTwice = true;
        }

        $visitedOnce[] = $cave->getName();

        foreach ($cave->getConnections() as $connection) {
            $this->findPath($connection, $newPath, $visitedOnce, $visitedTwice);
        }
    }
}
