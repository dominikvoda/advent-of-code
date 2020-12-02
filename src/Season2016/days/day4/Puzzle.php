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

namespace AdventOfCode\Season2016\Days\Day4;

use AdventOfCode\Season2016\Days\AbstractPuzzle;

class Puzzle extends AbstractPuzzle
{
    public function getInputType()
    {
        return self::LINES_INPUT;
    }

    public function resolve()
    {
        $sum = 0;

        //        foreach ($this->input as $input) {
        //            $sectorId = $this->getSectorId($input);
        //            if ($this->isReal($input)) {
        //                $sum += $sectorId;
        //            }
        //        }

        foreach ($this->input as $input) {
            if ($this->isReal($input)) {
                $sectorId = $this->getSectorId($input);

                $letters = $this->getAllLetters($input);
                $encrypted = '';
                for ($i = 0; $i < strlen($letters); $i++) {
                    $encrypted .= $this->getShiftedChar($letters[$i], $sectorId);
                }

                echo($encrypted . ' - ' . $this->getSectorId($input) . PHP_EOL);
            }
        }

        return $sum;
    }

    public function isReal($input)
    {
        $letters = $this->getAllLettersWithoutDashes($input);

        $countedCheckSum = $this->countLetters($letters);

        return $countedCheckSum === $this->getCheckSumFromInput($input);
    }

    private function getSectorId($input)
    {
        preg_match("/[0-9]+/", $input, $number);

        return $number[0];
    }

    private function getAllLetters($input)
    {
        preg_match("/(.*)-[0-9]/", $input, $letters);

        return $letters[1];
    }

    private function getAllLettersWithoutDashes($input)
    {
        preg_match("/(.*)-[0-9]/", $input, $letters);

        return str_replace('-', '', $letters[1]);
    }

    private function getCheckSumFromInput($input)
    {
        preg_match("/\[(.*)\]/", $input, $regex);

        return $regex[1];
    }

    private function countLetters($letters)
    {
        $result = [];
        for ($i = 0; $i < strlen($letters); $i++) {
            $letter = $letters[$i];
            if (array_key_exists($letter, $result)) {
                $result[$letter]++;
            } else {
                $result[$letter] = 1;
            }
        }

        arsort($result);

        return $this->countCheckSum($result);
    }

    private function countCheckSum($sortedLetters)
    {
        $grouped = [];
        foreach ($sortedLetters as $letter => $value) {
            $grouped[$value][] = $letter;
        }

        $key = '';
        $total = 0;

        foreach ($grouped as $letters) {
            asort($letters);
            foreach ($letters as $letter) {
                $key .= $letter;
                $total++;
                if ($total === 5) {
                    return $key;
                }
            }
        }

        return $key;
    }

    private function getShiftedChar($char, $id)
    {
        if ($char === '-') {
            return ' ';
        }

        //        $offset = $id % 26;

        $alphabet = 'abcdefghijklmnopqrstuvwxyz';

        $position = strpos($alphabet, $char);

        $key = ($id + $position) % 26;

        return $alphabet[$key];
    }
}
