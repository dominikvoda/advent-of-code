<?php

namespace AdventOfCode\Season2017\Classes;

class PlumberProgram
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var array
     */
    private $connections = [];

    /**
     * @var bool
     */
    private $visited;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
        $this->visited = false;
    }

    /**
     * @param PlumberProgram $program
     */
    public function addConnection(PlumberProgram $program)
    {
        if (!array_key_exists($program->getId(), $this->connections)) {
            $this->connections[$program->getId()] = $program;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isVisited(): bool
    {
        return $this->visited;
    }

    /**
     *
     */
    public function visit(): void
    {
        $this->visited = true;
    }

    /**
     * @return array
     */
    public function getConnectionIds(): array
    {
        return array_keys($this->connections);
    }

    /**
     * @param Village $village
     */
    public function traceConnections(Village $village)
    {
        foreach ($this->getConnectionIds() as $connectionId) {
            $connection = $village->getProgram($connectionId);
            if (!$connection->isVisited()) {
                $connection->visit();
                $connection->traceConnections($village);
            }
        }
    }
}
