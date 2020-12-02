<?php

namespace AdventOfCode\Season2017\Classes;

class Village
{
    /**
     * @var PlumberProgram[]
     */
    private $programs;

    /**
     */
    public function __construct()
    {
        $this->programs = [];
    }

    /**
     * @param string $input
     */
    public function addProgram(string $input): void
    {
        $programId = $this->parseProgramId($input);
        $program = new PlumberProgram($programId);

        $connections = $this->parseProgramConnections($input);
        foreach ($connections as $connectionId) {
            $connection = $this->findProgram($connectionId);

            $program->addConnection($connection);
            $connection->addConnection($program);
        }
    }

    /**
     * @param int $programId
     *
     * @return PlumberProgram
     */
    private function findProgram(int $programId): PlumberProgram
    {
        if (array_key_exists($programId, $this->programs)) {
            return $this->programs[$programId];
        }

        $program = new PlumberProgram($programId);
        $this->programs[$programId] = $program;

        return $this->findProgram($programId);
    }

    /**
     * @param int $programId
     *
     * @return PlumberProgram
     */
    public function getProgram(int $programId): PlumberProgram
    {
        return $this->programs[$programId];
    }

    /**
     * @param string $input
     *
     * @return int
     */
    private function parseProgramId(string $input): int
    {
        $parts = explode(' <-> ', $input);

        return $parts[0];
    }

    /**
     * @param string $input
     *
     * @return array
     */
    private function parseProgramConnections(string $input): array
    {
        $parts = explode(' <-> ', $input);
        $connections = explode(', ', $parts[1]);

        return $connections;
    }

    /**
     * @return int
     */
    public function countVisitedPrograms(): int
    {
        $total = 0;
        /** @var PlumberProgram $program */
        foreach ($this->programs as $program) {
            if ($program->isVisited()) {
                $total++;
            }
        }

        return $total;
    }

    /**
     * @return PlumberProgram|null
     */
    public function getNextUnvisitedProgram(): ?PlumberProgram
    {
        foreach ($this->programs as $program) {
            if (!$program->isVisited()) {
                return $program;
            }
        }

        return null;
    }
}
