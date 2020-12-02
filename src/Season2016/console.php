<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 11.08.2016
 * Time: 20:22
 */

use AdventOfCode\Season2016\Puzzle;
use Symfony\Component\Console\Application;

require __DIR__ . "/../../vendor/autoload.php";

$application = new Application("Advent of Code 2016 console application");

$application->add(new Puzzle());

$application->run();
