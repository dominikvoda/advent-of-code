<?php

namespace AdventOfCode\Season2016\Days\Day8;

class Grid
{
    private $display;

    public function __construct(int $rows, int $columns)
    {
        $this->setGroupCellValues($rows, $columns, '.');
    }

    public function turnOnRect(int $rows, int $columns)
    {
        $this->setGroupCellValues($rows, $columns, '#');
    }

    public function rotateRow(int $rowIndex, int $offset)
    {
        $row = $this->display[$rowIndex];
        $rotated = $this->rotateArray($row, $offset);

        $this->display[$rowIndex] = $rotated;
    }

    public function rotateColumn(int $columnIndex, int $offset)
    {
        $column = $this->loadColumn($columnIndex);
        $rotated = $this->rotateArray($column, $offset);

        $this->pasteColumn($columnIndex, $rotated);
    }

    private function rotateArray(array $array, int $offset)
    {
        $arraySize = count($array);
        $rotated = [];
        foreach ($array as $key => $value) {
            $newKey = ($key + $offset) % $arraySize;
            $rotated[$newKey] = $value;
        }

        ksort($rotated);

        return $rotated;
    }

    private function loadColumn(int $columnIndex)
    {
        $column = [];
        foreach ($this->display as $rows) {
            $column[] = $rows[$columnIndex];
        }

        return $column;
    }

    private function pasteColumn(int $columnIndex, array $columnValues)
    {
        foreach ($columnValues as $key => $value) {
            $this->display[$key][$columnIndex] = $value;
        }
    }

    private function setGroupCellValues(int $rows, int $columns, $value)
    {
        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $columns; $j++) {
                $this->display[$i][$j] = $value;
            }
        }
    }

    public function renderGrid()
    {
        foreach ($this->display as $rows) {
            foreach ($rows as $cell) {
                echo $cell;
            }
            echo PHP_EOL;
        }
    }

    public function getTurnedOnCount()
    {
        $count = 0;
        foreach ($this->display as $rows) {
            foreach ($rows as $cell) {
                if ($cell === '#') {
                    $count++;
                }
            }
        }

        return $count;
    }
}
