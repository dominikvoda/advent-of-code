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

namespace AdventOfCode\Season2016\Days\Day2;

use AdventOfCode\Season2016\Days\AbstractPuzzle;
use AdventOfCode\Season2016\Input;

class Puzzle extends AbstractPuzzle
{
    const INPUT_FILE = __DIR__ . "/input.txt";
    const DIRECTION_UP = "U";
    const DIRECTION_LEFT = "L";
    const DIRECTION_DOWN = "D";
    const DIRECTION_RIGHT = "R";

    protected $lines;

    protected $code;

    protected $currentPosition;

    protected static $codes = [
        "0-0" => "7",
        "0-1" => "4",
        "0-2" => "1",
        "1-0" => "8",
        "1-1" => "5",
        "1-2" => "2",
        "2-0" => "9",
        "2-1" => "6",
        "2-2" => "3",
    ];

    protected static $codes2 = [
        "2-0" => "D",
        "1-1" => "A",
        "2-1" => "B",
        "3-1" => "C",
        "0-2" => "5",
        "1-2" => "6",
        "2-2" => "7",
        "3-2" => "8",
        "4-2" => "9",
        "1-3" => "2",
        "2-3" => "3",
        "3-3" => "4",
        "2-4" => "1",
    ];

    public function getInputType()
    {
        return self::LINES_INPUT;
    }

    public function __construct()
    {
        $this->currentPosition = [1, 1];
        $this->code = [];
        $this->lines = Input::loadLinesIntoArray(self::INPUT_FILE);
    }

    public function resolve()
    {
        foreach ($this->lines as $line) {
            $this->resolveLine($line);
        }
        return join("", $this->code);
    }

    protected function resolveLine($line)
    {
        foreach (str_split($line) as $char) {
            $newPosition = $this->currentPosition;
            if ($char == self::DIRECTION_UP) {
                $newPosition[1]++;
            }
            if($char == self::DIRECTION_DOWN){
                $newPosition[1]--;
            }
            if($char == self::DIRECTION_LEFT){
                $newPosition[0]--;
            }
            if($char == self::DIRECTION_RIGHT){
                $newPosition[0]++;
            }
//            if($this->isMoveValid($newPosition)){
            if($this->isMoveValid2($newPosition)){
                $this->currentPosition = $newPosition;
            }
        }
//        $this->code[] = self::$codes[$this->createPositionKey($this->currentPosition)];
        $this->code[] = self::$codes2[$this->createPositionKey($this->currentPosition)];
    }

    protected function isMoveValid($newPosition){
        return array_key_exists($this->createPositionKey($newPosition), self::$codes);
    }

    protected function isMoveValid2($newPosition){
        return array_key_exists($this->createPositionKey($newPosition), self::$codes2);
    }

    protected function createPositionKey($position){
        return $position[0] . "-" . $position[1];
    }
}
