<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day3;

final class Rectangle
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $leftOffset;

    /**
     * @var int
     */
    private $topOffset;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;


    public function __construct(string $input)
    {
        preg_match('/^\#(\d+) @ (\d+),(\d+): (\d+)x(\d+)$/', $input, $matches);

        $this->id = (int)$matches[1];
        $this->leftOffset = (int)$matches[2];
        $this->topOffset = (int)$matches[3];
        $this->width = (int)$matches[4];
        $this->height = (int)$matches[5];
    }


    public function getCoordinates(): array
    {
        $coordinates = [];

        for ($i = 0; $i < $this->height; $i++) {
            for ($j = 0; $j < $this->width; $j++) {
                $x = $this->leftOffset + $j;
                $y = $this->topOffset + $i;
                $coordinates[] = $y . ':' . $x;
            }
        }

        return $coordinates;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
