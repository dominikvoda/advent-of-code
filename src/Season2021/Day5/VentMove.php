<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day5;

use function array_fill;
use function count;
use function range;

final class VentMove
{
    private int $startX;

    private int $startY;

    private int $endX;

    private int $endY;


    public function __construct(string $line)
    {
        preg_match('/(?<startX>\d+),(?<startY>\d+) -> (?<endX>\d+),(?<endY>\d+)/', $line, $output);
        $this->startX = (int)$output['startX'];
        $this->startY = (int)$output['startY'];
        $this->endX = (int)$output['endX'];
        $this->endY = (int)$output['endY'];
    }


    public function isDiagonal(): bool
    {
        return !$this->isVertical() && !$this->isHorizontal();
    }


    public function isVertical(): bool
    {
        return $this->startX === $this->endX;
    }


    public function isHorizontal(): bool
    {
        return $this->startY === $this->endY;
    }


    public function getAllCoordinates(): array
    {
        $vertical = range($this->startX, $this->endX);
        $horizontal = range($this->startY, $this->endY);
        if(count($vertical) === 1){
            $vertical = array_fill(0, count($horizontal), $this->startX);
        }
        if(count($horizontal) === 1){
            $horizontal = array_fill(0, count($vertical), $this->startY);
        }

        $coordinates = [];
        foreach ($vertical as $i => $x) {
            $coordinates[] = $x . '-' . $horizontal[$i];
        }

        return $coordinates;
    }
}
