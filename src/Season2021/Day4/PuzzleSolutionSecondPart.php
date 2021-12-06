<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day4;

use AdventOfCode\IntegerResult;
use AdventOfCode\InvalidResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_chunk;
use function array_map;
use function array_shift;
use function explode;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    /**
     * @var int[]
     */
    private $moves;

    /**
     * @var BingoBoard[]
     */
    private $boards;


    public function __construct()
    {
        $input = new LinesInput(__DIR__ . '/input.txt');
        $lines = $input->getLines();
        $this->moves = array_map('intval', explode(',', array_shift($lines)));
        $this->boards = array_map(static function (array $input): BingoBoard {
            return new BingoBoard($input);
        }, array_chunk($lines, 6));
    }


    public function getResult(): Result
    {
        foreach ($this->moves as $move) {
            foreach ($this->boards as $index => $board) {
                if ($board->play($move)) {
                    unset($this->boards[$index]);
                }

                if ($this->boards === []) {
                    return new IntegerResult($move * $board->getSumOfLeft());
                }
            }
        }

        return new InvalidResult();
    }
}
