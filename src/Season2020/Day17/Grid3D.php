<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day17;

use AdventOfCode\LinesInput;
use function str_split;

final class Grid3D
{
    /**
     * @var bool[][][]
     */
    private $cells;

    /**
     * @var int
     */
    private $totalActive;


    public function __construct()
    {
        $this->cells = [];
        $this->totalActive = 0;
    }


    public static function fromInputFile(string $inputFile): self
    {
        $input = new LinesInput($inputFile);

        $grid = new self();

        $y = 0;
        foreach ($input->getLines() as $line) {
            $chars = str_split($line);

            foreach ($chars as $x => $char) {
                $grid->setCell($x, $y, 0, $char === '#');
            }

            $y++;
        }

        return $grid;
    }


    public function getCells(): array
    {
        return $this->cells;
    }


    public function setCell(int $x, int $y, int $z, bool $active): void
    {
        $this->cells[$x][$y][$z] = $active;

        if ($active) {
            $this->totalActive++;
        }

        $neighbours = $this->getNeighboursCoordinates($x, $y, $z);

        foreach ($neighbours as $neighbour) {
            if (!isset($this->cells[$neighbour['x']][$neighbour['y']][$neighbour['z']])) {
                $this->cells[$neighbour['x']][$neighbour['y']][$neighbour['z']] = false;
            }
        }
    }


    public function getTotalActive(): int
    {
        return $this->totalActive;
    }


    private function countActiveNeighbours(int $x, int $y, int $z): int
    {
        $coordinates = $this->getNeighboursCoordinates($x, $y, $z);

        $active = 0;

        foreach ($coordinates as $coordinate) {
            $neighbour = $this->cells[$coordinate['x']][$coordinate['y']][$coordinate['z']] ?? false;

            if ($neighbour) {
                $active++;
            }
        }

        return $active;
    }


    public function getNewValue(int $x, int $y, int $z): bool
    {
        $active = $this->cells[$x][$y][$z];
        $activeNeighbours = $this->countActiveNeighbours($x, $y, $z);

        if ($active && ($activeNeighbours === 2 || $activeNeighbours === 3)) {
            return true;
        }

        if (!$active && $activeNeighbours === 3) {
            return true;
        }

        return false;
    }


    private function getNeighboursCoordinates(int $x, int $y, int $z): array
    {
        $neighbourCoordinates = [];

        for ($i = -1; $i < 2; $i++) {
            for ($j = -1; $j < 2; $j++) {
                for ($k = -1; $k < 2; $k++) {
                    if ($i === 0 && $j === 0 && $k === 0) {
                        continue;
                    }

                    $neighbourCoordinates[] = [
                        'x' => $x + $i,
                        'y' => $y + $j,
                        'z' => $z + $k,
                    ];
                }
            }
        }

        return $neighbourCoordinates;
    }
}
