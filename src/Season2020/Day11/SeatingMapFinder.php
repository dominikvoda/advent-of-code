<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day11;

use AdventOfCode\LinesInput;
use function array_map;
use function count;

final class SeatingMapFinder
{
    /**
     * @var string
     */
    private $seatingMapClass;

    /**
     * @var int
     */
    private $humanTolerance;


    public function __construct(string $seatingMapClass, int $humanTolerance)
    {
        $this->seatingMapClass = $seatingMapClass;
        $this->humanTolerance = $humanTolerance;
    }


    public function findFinalSeatingMap(string $inputFile): SeatingMap
    {
        $input = new LinesInput($inputFile);
        $seats = array_map('str_split', $input->getLines());

        $height = $input->getSize();
        $width = count($seats[0]);
        $seatingMapClass = $this->seatingMapClass;

        $currentSeatingMap = new $seatingMapClass($seats);

        while (true) {
            $nextSeats = [];
            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {
                    $seat = $currentSeatingMap->getSeat($y, $x);

                    $nearestOccupied = $currentSeatingMap->countOccupiedAround($y, $x);

                    if ($seat === 'L' && $nearestOccupied === 0) {
                        $nextSeats[$y][$x] = '#';
                        continue;
                    }

                    if ($seat === '#' && $nearestOccupied >= $this->humanTolerance) {
                        $nextSeats[$y][$x] = 'L';
                        continue;
                    }

                    $nextSeats[$y][$x] = $seat;
                }
            }

            $nextSeatingMap = new $seatingMapClass($nextSeats);

            if ($currentSeatingMap->isSame($nextSeatingMap)) {
                return $currentSeatingMap;
            }

            $currentSeatingMap = $nextSeatingMap;
        }
    }
}
