<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day13;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_filter;
use function array_map;
use function gmp_lcm;
use function gmp_mod;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    /**
     * @var int
     */
    private $timestamp;

    /**
     * @var int
     */
    private $step;


    public function __construct()
    {
        $this->timestamp = 0;
        $this->step = 1;
    }


    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');
        preg_match_all('/(\d+|x)/', $input->getLines()[1], $schedule);

        $buses = array_filter($schedule[0], 'is_numeric');
        $buses = array_map('intval', $buses);
        $previous = 1;

        foreach ($buses as $offset => $bus) {
            while (true) {
                $minutesDiff = (int)gmp_mod($this->timestamp + $offset, $bus);

                if ($minutesDiff === 0) {
                    $this->step = (int)gmp_lcm($previous, $bus);
                    $previous = $this->step;
                    break;
                }

                $this->timestamp += $this->step;
            }
        }

        return new IntegerResult($this->timestamp);
    }
}
