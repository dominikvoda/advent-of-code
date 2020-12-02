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

namespace AdventOfCode\Season2016\Days\Day5;

use AdventOfCode\Season2016\Days\AbstractPuzzle;

class Puzzle extends AbstractPuzzle
{
    public function getInputType()
    {
        return self::NO_INPUT;
    }

    public function resolve()
    {
        $prefix = 'ffykfhsq';
        $i = 0;
        $turns = 0;
        $result = [];
        while ($turns !== 8) {
            $md5 = md5($prefix . $i);
            if (substr($md5, 0, 5) === '00000') {
                $position = $md5[5];
                if ($position >= '0' && $position <= '7') {
                    if (!array_key_exists($position, $result)) {
                        $result[$position] = $md5[6];
                        $turns++;
                    }
                }
            }
            if ($i % 1000 == 0) {
                echo $i . ' turns: ' . $turns . "\n";
            }
            $i++;
        }

        var_dump($result);

        $message = '';

        foreach ($result as $char) {
            $message .= $char;
        }

        return $message;
    }
}
