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

namespace AdventOfCode\Season2016\Days\Day7;

use AdventOfCode\Season2016\Days\AbstractPuzzle;

class Puzzle extends AbstractPuzzle
{
    public function getInputType()
    {
        return self::LINES_INPUT;
    }

    public function resolve()
    {
        $result = 0;

        foreach ($this->input as $input) {
            if ($this->isStringSupportTLS($input)) {
                $result++;
            }
        }

        return $result;
    }

    private function getInBracketsStrings($input)
    {
        preg_match_all("/\[[a-z]*\]/", $input, $matches);

        return $matches[0];
    }

    private function getOutOfBracketsStrings($input)
    {
        $replaced = preg_replace("/\[([a-z]*)\]/", " ", $input);

        return $replaced;
    }

    private function containsABBA($strings)
    {
        foreach ($strings as $string) {
            if ($this->isStringContainAbba($string)) {
                return true;
            }
        }

        return false;
    }

    private function isStringContainAbba($string)
    {
        $matches = preg_match_all("/(\w+)(\w+)\\2\\1/", $string, $result);

        if ($matches > 0) {
            foreach ($result[1] as $key => $char) {
                if ($char !== $result[2][$key]) {
                    return true;
                }
            }
        }

        return false;
    }

    public function isStringSupportTLS($string)
    {
        $inBrackets = $this->getInBracketsStrings($string);
        $outOfBrackets = [$this->getOutOfBracketsStrings($string)];

        return !$this->containsABBA($inBrackets) && $this->containsABBA($outOfBrackets);
    }
}
