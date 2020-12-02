<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 01.12.2016
 * Time: 13:57
 */

namespace AdventOfCode\Season2016;

/**
 * Class Input
 * @package AdventOfCode\Season2016
 */
class Input
{
    /**
     * @param string $file
     * @return string
     */
    public static function loadIntoVariable($file){
        return file_get_contents($file);
    }

    /**
     * @param string $file
     * @return array
     */
    public static function loadLinesIntoArray($file){
        $array = [];
        $handle = fopen($file, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $array[] = $line;
            }
            fclose($handle);
        }
        else{
            throw new \RuntimeException("Can't read file {$file}");
        }
        return $array;
    }
}
