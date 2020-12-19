<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day17;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;

final class PuzzleSolutionSecondPart implements PuzzleSolution
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
            $newGrid = new Grid4D();
            foreach ($this->grid->getCells() as $x => $columns) {
                foreach ($columns as $y => $rows) {
                    foreach ($rows as $z => $hypers) {
                        foreach ($hypers as $w => $cell) {
                            $newValue = $this->grid->getNewValue($x, $y, $z, $w);
                            $newGrid->setCell($x, $y, $z, $w, $newValue);
                        }
                    }
                }
            }

            $this->grid = $newGrid;
        }

        return new IntegerResult($this->grid->getTotalActive());
    }
}
