<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Day6;

class Orbit
{
    /**
     * @var Orbit|null
     */
    private $previous;

    /**
     * @var Orbit|null
     */
    private $next;

    /**
     * @var string
     */
    private $name;


    public function __construct(string $name, ?Orbit $previous, ?Orbit $next)
    {
        $this->previous = $previous;
        $this->next = $next;
        $this->name = $name;
    }


    public function getPrevious(): ?Orbit
    {
        return $this->previous;
    }


    public function getNext(): ?Orbit
    {
        return $this->next;
    }


    public function setPrevious(Orbit $previous): void
    {
        $this->previous = $previous;
    }


    public function setNext(Orbit $next): void
    {
        $this->next = $next;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function hasPrevious(): bool
    {
        return $this->previous !== null;
    }


    public function hasNext(): bool
    {
        return $this->next !== null;
    }
}
