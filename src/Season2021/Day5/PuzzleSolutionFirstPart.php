<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day5;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_filter;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    /**
     * @var VentMove[]
     */
    private array $ventMoves;


    public function __construct()
    {
        $this->ventMoves = LinesInput::createAsObjects(__DIR__ . '/input.txt', VentMove::class);
    }


    public function getResult(): Result
    {
        $coordinates = [];
        foreach ($this->ventMoves as $ventMove) {
            if (!$ventMove->isDiagonal()) {
                foreach ($ventMove->getAllCoordinates() as $coordinate) {
                    if (!isset($coordinates[$coordinate])) {
                        $coordinates[$coordinate] = 1;
                        continue;
                    }

                    $coordinates[$coordinate]++;
                }
            }
        }

        $resultCoordinates = array_filter($coordinates, static function (int $crosses): bool {
            return $crosses > 1;
        });

        return IntegerResult::fromArrayCount($resultCoordinates);
    }
}
