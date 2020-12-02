<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 01.12.2016
 * Time: 14:12
 */

namespace AdventOfCode\Season2016;

use AdventOfCode\Season2016\Days\AbstractPuzzle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle extends Command
{
    protected function configure()
    {
        $this->setName("puzzle:day");
        $this->addArgument("day");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $day = $input->getArgument("day");

        $puzzleClass = "\\AdventOfCode\Season2016\\Days\\Day" . $day . "\\Puzzle";

        $folder = __DIR__ . "/days/day" . $day;

        /** @var AbstractPuzzle $puzzle */
        $puzzle = new $puzzleClass();

        $puzzle->loadInput($puzzle->getInputType(), $folder . '/input.txt');

        $output->writeln("Result first part: " . $puzzle->resolve());
        $output->writeln("Result second part: " . $puzzle->resolveSecond());
    }

}
