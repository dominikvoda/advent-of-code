<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day17;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    /**
     * @var Grid4D
     */
    private $grid;


    public function __construct()
    {
        $this->grid = Grid4D::fromInputFile(__DIR__ . '/input.txt');
    }


    public function getResult(): Result
    {
        for ($i = 0; $i < 6; $i++) {
            $newGrid = new Grid3D();
            foreach ($this->grid->getCells() as $x => $columns) {
                foreach ($columns as $y => $rows) {
                    foreach ($rows as $z => $cell) {
                        $newValue = $this->grid->getNewValue($x, $y, $z);
                        $newGrid->setCell($x, $y, $z, $newValue);
                    }
                }
            }

            $this->grid = $newGrid;
        }

        return new IntegerResult($this->grid->getTotalActive());
    }
}
