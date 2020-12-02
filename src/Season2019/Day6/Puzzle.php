<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Day6;

use AdventOfCode\Season2019\Input;
use AdventOfCode\Season2019\PuzzleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use function explode;

class Puzzle implements PuzzleInterface
{
    public function resolveFirstPart(): string
    {
        $total = 0;
        $orbits = $this->loadUniverse();

        foreach ($orbits as $orbit) {
            if ($orbit->hasPrevious()) {
                $total += $this->countPreviousOrbits($orbit);
            }
        }

        return (string)$total;
    }


    public function resolveSecondPart(): string
    {
        $orbits = $this->loadUniverse();

        $you = $orbits->get('YOU');
        $san = $orbits->get('SAN');

        $youPath = $this->getPath($you);
        $sanPath = $this->getPath($san);

        $youLength = 0;

        foreach ($youPath as $youOrbit) {
            $sanLength = 0;
            foreach ($sanPath as $sanOrbit) {
                if($youOrbit->getName() === $sanOrbit->getName()){
                    break 2;
                }
                $sanLength++;
            }
            $youLength++;
        }

        return (string)($sanLength + $youLength - 2);
    }


    private function loadUniverse(): Collection
    {
        /** @var Collection|Orbit[] $orbits */
        $orbits = new ArrayCollection();

        $input = Input::linesFromFile(__DIR__ . '/input.txt');

        foreach ($input as $line) {
            $parts = explode(')', $line);

            $orbitLeftName = $parts[0];
            $orbitRightName = $parts[1];

            $orbitLeft = $orbits->get($orbitLeftName);
            $orbitRight = $orbits->get($orbitRightName);

            if ($orbitLeft === null) {
                $orbitLeft = new Orbit($orbitLeftName, null, null);
            }

            if ($orbitRight === null) {
                $orbitRight = new Orbit($orbitRightName, null, null);
            }

            $orbitLeft->setNext($orbitRight);
            $orbitRight->setPrevious($orbitLeft);

            $orbits->set($orbitLeft->getName(), $orbitLeft);
            $orbits->set($orbitRight->getName(), $orbitRight);
        }

        return $orbits;
    }


    /**
     * @return Collection|Orbit[]
     */
    private function getPath(Orbit $orbit): Collection
    {
        $path = new ArrayCollection();
        $currentOrbit = $orbit;

        while ($currentOrbit->hasPrevious()) {
            $path->set($currentOrbit->getName(), $currentOrbit);
            $currentOrbit = $currentOrbit->getPrevious();
        }

        return $path;
    }


    private function countPreviousOrbits(Orbit $orbit, int $total = 0): int
    {
        if (!$orbit->hasPrevious()) {
            return $total;
        }

        return $this->countPreviousOrbits($orbit->getPrevious(), ++$total);
    }
}
