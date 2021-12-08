<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day6;

use function abs;
use function explode;

final class Coordinate
{
    private static $sequence = 'a';

    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @var int
     */
    private $area;

    /**
     * @var string
     */
    private $id;


    public function __construct(string $input)
    {
        $parts = explode(', ', $input);
        $this->x = (int)$parts[0];
        $this->y = (int)$parts[1];
        $this->area = 0;
        $this->id = self::$sequence++;
    }


    public function getDistance(int $y, int $x): int
    {
        return abs($this->x - $x) + abs($this->y - $y);
    }


    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }


    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }


    public function increaseArea(): void
    {
        $this->area++;
    }


    public function getArea(): int
    {
        return $this->area;
    }


    public function getId(): string
    {
        return $this->id;
    }


    public static function compareByX(self $coordinateA, self $coordinateB): int
    {
        return $coordinateA->getX() > $coordinateB->getX() ? 1 : -1;
    }


    public static function compareByY(self $coordinateA, self $coordinateB): int
    {
        return $coordinateA->getY() > $coordinateB->getY() ? 1 : -1;
    }
}
