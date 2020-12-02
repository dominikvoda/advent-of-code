<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 01.12.2016
 * Time: 14:14
 */

namespace AdventOfCode\Season2016\Days;

use AdventOfCode\Season2016\Input;

/**
 * Class AbstractPuzzle
 *
 * @package AdventOfCode\Season2016\Days
 */
abstract class AbstractPuzzle
{
    protected $input;

    const LINES_INPUT = 'lines';
    const VARIABLE_INPUT = 'variable';
    const NO_INPUT = 'nothing';
    const INPUT_TYPE = 'you should implement it in puzzle class';

    public function loadInput($mode = self::LINES_INPUT, $file)
    {
        if ($mode === self::NO_INPUT) {
            return;
        }
        if ($mode === self::LINES_INPUT) {
            $this->input = Input::loadLinesIntoArray($file);
        }
        if ($mode === self::VARIABLE_INPUT) {
            $this->input = Input::loadIntoVariable($file);
        }
    }

    abstract public function getInputType();

    public function resolve()
    {
        return 'not implemented';
    }

    public function resolveSecond()
    {
        return 'not implemented';
    }
}
