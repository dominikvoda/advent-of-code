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

namespace AdventOfCode\Season2016\Days\Day6;

use AdventOfCode\Season2016\Days\AbstractPuzzle;

class Puzzle extends AbstractPuzzle
{
    public function getInputType()
    {
        return self::LINES_INPUT;
    }

    public function resolve()
    {
        $inputLength = 8;

        $results = $this->initResultsArray();

        foreach ($this->input as $input) {
            for ($i = 0; $i < $inputLength; $i++) {
                $char = $input[$i];
                $results[$i][$char]++;
            }
        }

        $message = '';

        foreach ($results as $position){
            arsort($position);

            $keys = array_keys($position);
            $message .= $keys[0];
        }

        return $message;
    }

    private function initResultsArray()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        $results = [];
        for ($i = 0; $i < 26; $i++) {
            for($j = 0; $j < 8; $j++){
                $results[$j][$alphabet[$i]] = 0;
            }
        }

        return $results;
    }

    public function resolveSecond()
    {
        $inputLength = 8;

        $results = $this->initResultsArray();

        foreach ($this->input as $input) {
            for ($i = 0; $i < $inputLength; $i++) {
                $char = $input[$i];
                $results[$i][$char]++;
            }
        }

        $message = '';

        foreach ($results as $position){
            asort($position);

            $keys = array_keys($position);
            $message .= $keys[0];
        }

        return $message;
    }


}
