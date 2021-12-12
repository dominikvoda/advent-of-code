<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day12;

use Nette\Utils\Strings;
use function in_array;

final class Cave
{
    private string $name;

    private array $connections = [];


    public function __construct(string $name, ?Cave $connection)
    {
        $this->name = $name;

        if ($connection === null) {
            return;
        }

        $this->connections[] = $connection;
    }


    public function addConnection(Cave $connection): void
    {
        if (in_array($connection, $this->connections, true)) {
            return;
        }

        $this->connections[] = $connection;
    }


    public function isSmall(): bool
    {
        return Strings::lower($this->name) === $this->name;
    }


    public function isStart(): bool
    {
        return $this->name === 'start';
    }


    public function isEnd(): bool
    {
        return $this->name === 'end';
    }


    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @return Cave[]
     */
    public function getConnections(): array
    {
        return $this->connections;
    }
}
