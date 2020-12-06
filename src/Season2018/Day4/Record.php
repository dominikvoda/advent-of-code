<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Day4;

use Nette\Utils\Strings;
use function substr;

final class Record
{
    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $command;


    public function __construct(string $input)
    {
        preg_match('/^\[(.*)\] (.*)$/', $input, $matches);
        $this->createdAt = $matches[1];
        $this->command = $matches[2];
    }


    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }


    public function isBeginsShift(): bool
    {
        return Strings::contains($this->command, 'Guard');
    }


    public function isFallsAsleep(): bool
    {
        return $this->command === 'falls asleep';
    }


    public function isWakesUp(): bool
    {
        return $this->command === 'wakes up';
    }


    public function getMinutes(): int
    {
        return (int)substr($this->createdAt, -2);
    }


    public function getGuardId(): int
    {
        preg_match('/^Guard \#(\d+) begins shift$/', $this->command, $matches);

        return (int)$matches[1];
    }
}
