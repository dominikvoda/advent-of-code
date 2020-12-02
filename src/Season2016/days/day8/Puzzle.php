<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 01.12.2016
 * Time: 13:56
 */

namespace AdventOfCode\Season2016\Days\Day8;

use AdventOfCode\Season2016\Days\AbstractPuzzle;

class Puzzle extends AbstractPuzzle
{
    const COMMAND_RECT = 'rect';
    const COMMAND_ROTATE_ROW = 'rotate row';
    const COMMAND_ROTATE_COLUMN = 'rotate column';

    public function getInputType()
    {
        return self::LINES_INPUT;
    }

    public function resolve()
    {
        //        $grid = new Grid(3, 8);
        //        $grid->turnOnRect(2, 3);
        //        $grid->rotateColumn(1, 1);
        //        $grid->rotateRow(0, 4);
        //        $grid->rotateColumn(1, 1);

        $grid = new Grid(6, 50);

        foreach ($this->input as $input) {
            $this->executeGridCommand($input, $grid);
        }

        $grid->renderGrid();

        return $grid->getTurnedOnCount();
    }

    private function executeGridCommand(string $input, Grid $grid)
    {
        if (preg_match("/rotate column x=+(\d+)+ by +(\d+)/", $input, $result)) {
            $grid->rotateColumn($result[1], $result[2]);
        }

        if (preg_match("/rotate row y=+(\d+)+ by +(\d+)/", $input, $result)) {
            $grid->rotateRow($result[1], $result[2]);
        }

        if (preg_match("/rect +(\d+)+x+(\d+)/", $input, $result)) {
            $grid->turnOnRect($result[2], $result[1]);
        }
    }
}
