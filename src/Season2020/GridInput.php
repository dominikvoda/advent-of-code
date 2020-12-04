<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020;

use function str_split;

final class GridInput
{
    /**
     * @var array
     */
    private $grid;

    /**
     * @var int
     */
    private $maxWidth;

    /**
     * @var int
     */
    private $height;


    public function __construct(string $inputFile)
    {
        $linesInput = new LinesInput($inputFile);

        $grid = [];
        $maxWidth = 0;

        foreach ($linesInput->getLines() as $y => $chars) {
            $grid[$y] = str_split($chars);

            if (count($grid[$y]) > $maxWidth) {
                $maxWidth = count($grid[$y]);
            }
        }

        $this->grid = $grid;
        $this->maxWidth = $maxWidth;
        $this->height = $linesInput->getSize();
    }


    public function getChar(int $y, int $x): string
    {
        return $this->grid[$y][$x];
    }


    public function getMaxWidth(): int
    {
        return $this->maxWidth;
    }


    public function getHeight(): int
    {
        return $this->height;
    }
}
