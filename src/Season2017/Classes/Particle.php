<?php

namespace AdventOfCode\Season2017\Classes;

class Particle
{
    /**
     * @var array
     */
    private $position;

    /**
     * @var array
     */
    private $velocity;

    /**
     * @var array
     */
    private $acceleration;

    /**
     * @var
     */
    private $distances;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var int
     */
    private $pointer;

    /**
     * @var bool
     */
    private $destroyed;

    private $positionStamp;

    /**
     * @param string $input
     */
    public function __construct(string $input)
    {
        preg_match("/p=<(.*)>, v=<(.*)>, a=<(.*)>/", $input, $regex);
        $this->position = explode(',', $regex[1]);
        $this->velocity = explode(',', $regex[2]);
        $this->acceleration = explode(',', $regex[3]);
        $this->active = true;
        $this->pointer = 0;
        $this->destroyed = false;
    }

    public function tick(): void
    {
        $this->velocity = $this->addArray($this->velocity, $this->acceleration);
        $this->position = $this->addArray($this->position, $this->velocity);
        $this->distances[] = $this->getDistance();
        if ($this->pointer > 2) {
            $this->resolveActive();
        }
        $this->positionStamp = $this->createPositionStamp();
    }

    /**
     * @return int
     */
    private function getDistance(): int
    {
        return abs($this->position[0]) + abs($this->position[1]) + abs($this->position[2]);
    }

    /**
     * @param array $first
     * @param array $second
     * @param int   $items
     *
     * @return array
     */
    private function addArray(array $first, array $second, int $items = 3): array
    {
        $result = [];
        for ($i = 0; $i < $items; $i++) {
            $result[$i] = $first[$i] + $second[$i];
        }

        return $result;
    }

    /**
     * @return float
     */
    public function getAvgDistance(): float
    {
        $total = count($this->distances);

        return array_sum($this->distances) / $total;
    }

    private function resolveActive(): void
    {
        $pointer = $this->pointer;
        $lvl1 = $this->distances[$pointer];
        $lvl2 = $this->distances[$pointer - 1];
        $lvl3 = $this->distances[$pointer - 2];
        $lvl4 = $this->distances[$pointer - 3];
        if ($lvl1 < $lvl2 && $lvl2 < $lvl3 && $lvl3 < $lvl4) {
            $this->active = false;
        }
        if ($lvl1 > $lvl2 && $lvl2 > $lvl3 && $lvl3 > $lvl4) {
            $this->active = false;
        }
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param string $positionStamp
     *
     * @return bool
     */
    public function checkCollision(string $positionStamp): bool
    {
        if ($this->isOk()) {
            if ($this->getPositionStamp() === $positionStamp) {
                $this->destroyed = true;

                return true;
            }

            return false;
        }

        return true;
    }

    /**
     * @param array $position1
     * @param array $position2
     *
     * @return bool
     */
    private function isCollision(array $position1, array $position2): bool
    {
        $collisions = 0;
        for ($i = 0; $i < 3; $i++) {
            if ($position1[$i] === $position2[$i]) {
                $collisions++;
            }
        }

        return $collisions === 3;
    }

    /**
     * @return bool
     */
    public function isOk(): bool
    {
        return $this->destroyed === false;
    }

    /**
     * @return array
     */
    public function getPosition(): array
    {
        return $this->position;
    }

    public function destroy(): void
    {
        $this->destroyed = true;
    }

    /**
     * @return string
     */
    private function createPositionStamp()
    {
        return join('_', $this->position);
    }

    /**
     * @return mixed
     */
    public function getPositionStamp()
    {
        return $this->positionStamp;
    }
}
