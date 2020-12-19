<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day16;

use function array_diff;
use function array_map;
use function count;
use function preg_match_all;

final class Ticket
{
    /**
     * @var array
     */
    private $numbers;


    public function __construct(array $numbers)
    {
        $this->numbers = $numbers;
    }


    public static function createFromString(string $numbers): self
    {
        preg_match_all('/(\d+)/', $numbers, $ticketNumbers);

        return new self(array_map('intval', $ticketNumbers[1]));
    }


    public function isValid(Fields $fields): bool
    {
        return $this->getInvalidNumbers($fields) === [];
    }


    public function getInvalidNumbers(Fields $fields): array
    {
        return array_diff($this->numbers, $fields->getAllValidNumbers());
    }


    public function getSize(): int
    {
        return count($this->numbers);
    }


    public function getNumber(int $numberIndex): int
    {
        return $this->numbers[$numberIndex];
    }
}
