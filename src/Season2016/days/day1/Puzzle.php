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

namespace AdventOfCode\Season2016\Days\Day1;


use AdventOfCode\Season2016\Days\AbstractPuzzle;
use AdventOfCode\Season2016\Input;
use function var_dump;

class Puzzle extends AbstractPuzzle
{
    const DIRECTION_UP = "up";
    const DIRECTION_LEFT = "left";
    const DIRECTION_DOWN = "down";
    const DIRECTION_RIGHT = "right";

    protected static $directionArray = [
        0 => self::DIRECTION_UP,
        1 => self::DIRECTION_LEFT,
        2 => self::DIRECTION_DOWN,
        3 => self::DIRECTION_RIGHT,
    ];

    public function getInputType()
    {
        return self::VARIABLE_INPUT;
    }

    protected $input;

    protected $currentLocation = [0, 0];

    protected $direction;

    protected $visitedLocations = [];
    protected $twiceVisitedLocations = [];

    const INPUT_FILE = __DIR__ . "/input.txt";

    public function __construct()
    {
        $this->direction = self::$directionArray[0];
    }

    public function resolve(){
        $this->isVisitedTwice($this->currentLocation);
        foreach (explode(", ", $this->input) as $command){
            $this->currentLocation = $this->getNewCoordinates($command);
        }

        $this->currentLocation = $this->getFirstTwiceVisitedLocation();

        $x = $this->currentLocation[0];
        $y = $this->currentLocation[1];

        return abs($x) + abs($y);
    }

    protected function getNewCoordinates($command){
        $turn = $command[0];
        $length = substr($command, 1);
        $this->direction = $this->updateDirection($turn);
        $location = $this->currentLocation;

        if(self::$directionArray[$this->direction] == self::DIRECTION_UP){
            for($i = 0; $i < $length; $i++){
                $location[1]++;
                $this->addVisitedLocation($location);
            }
        }
        if(self::$directionArray[$this->direction] == self::DIRECTION_DOWN){
            for($i = 0; $i < $length; $i++){
                $location[1]--;
                $this->addVisitedLocation($location);
            }
        }
        if(self::$directionArray[$this->direction] == self::DIRECTION_RIGHT){
            for($i = 0; $i < $length; $i++){
                $location[0]++;
                $this->addVisitedLocation($location);
            }
        }
        if(self::$directionArray[$this->direction] == self::DIRECTION_LEFT){
            for($i = 0; $i < $length; $i++){
                $location[0]--;
                $this->addVisitedLocation($location);
            }
        }
        return $location;
    }

    protected function updateDirection($turn){
        if($turn == "L"){
            $this->direction++;
        }
        else{
            $this->direction--;
        }
        if($this->direction < 0){
            $this->direction = 3;
        }
        return $this->direction % 4;
    }

    protected function isVisitedTwice($coordinates){
        $location = $coordinates[0] . "-" . $coordinates[1];
        if(in_array($location, $this->visitedLocations)){
            return true;
        }
        $this->addVisitedLocation($location);
        return false;
    }

    protected function addVisitedLocation($location){
        $this->visitedLocations[] = $location;
    }

    protected function getFirstTwiceVisitedLocation(){
        $size = count($this->visitedLocations);
        foreach ($this->visitedLocations as $index => $location){
            for($i = $index + 1; $i < $size; $i++){

                if($this->visitedLocations[$i][0] == $location[0] && $this->visitedLocations[$i][1] == $location[1]){
                    return $location;
                }
            }
        }
        return [0, 0];
    }
}
