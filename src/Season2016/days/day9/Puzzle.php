<?php

namespace AdventOfCode\Season2016\Days\Day9;

use AdventOfCode\Season2016\Days\AbstractPuzzle;

class Puzzle extends AbstractPuzzle
{
    public function getInputType()
    {
        return self::VARIABLE_INPUT;
    }

    public function resolve()
    {
        preg_match_all("/[^A-Z]+[A-Z]+/", $this->input, $markers);

        $total = 0;

        foreach ($markers[0] as $marker) {
            $total += strlen($this->getMarkerSize($marker));
        }

        return $total;
    }

    public function getMarkerSize($string)
    {
        $marker = $this->getMarkerFromString($string);

        if ($marker) {
            $markerSize = strlen($marker);
            $substring = substr($string, $markerSize);
            preg_match_all("/\d+/", $marker, $numbers);
            $result = $this->multipleSubstring($substring, $numbers[0][0], $numbers[0][1]);

            return $result;
        }

        return $string;
    }

    public function getMarkerFromString(string $string)
    {
        preg_match_all("/\d+/", $string, $numbers);
        $numbers = $numbers[0];

        if (count($numbers) >= 2) {
            return '(' . $numbers[0] . 'x' . $numbers[1] . ')';
        }

        return false;
    }

    public function multipleSubstring($string, $offset, $multipleCount)
    {
        $suffix = substr($string, $offset);
        $substring = substr($string, 0, $offset);
        $result = '';
        for ($i = 0; $i < $multipleCount; $i++) {
            $result .= $substring;
        }
        $result .= $suffix;

        return $result;
    }
}
