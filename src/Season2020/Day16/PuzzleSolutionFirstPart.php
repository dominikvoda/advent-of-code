<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day16;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_diff;
use function array_map;
use function array_merge;
use function explode;
use const PHP_EOL;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt', PHP_EOL . PHP_EOL);

        $allFields = explode(PHP_EOL, $input->getLines()[0]);
        preg_match_all('/(\d+)/', $input->getLines()[1], $myTicketNumbers);
        preg_match_all('/(\d+)/', $input->getLines()[2], $nearbyTicketNumbers);

        $myTicketNumbers = array_map('intval', $myTicketNumbers[0]);
        $nearbyTicketNumbers = array_map('intval', $nearbyTicketNumbers[0]);
        $allValidNumbers = $this->getAllValidNumbers($allFields);

        $errors = array_diff($nearbyTicketNumbers, $allValidNumbers);

        return IntegerResult::fromArraySum($errors);
    }


    private function getAllValidNumbers(array $allFields): array
    {
        $validNumbers = [];

        foreach ($allFields as $field) {
            preg_match('/(\d+)-(\d+) or (\d+)-(\d+)/', $field, $numbers);
            $validNumbers = array_merge($validNumbers, range((int)$numbers[1], (int)$numbers[2]));
            $validNumbers = array_merge($validNumbers, range((int)$numbers[3], (int)$numbers[4]));
        }

        return $validNumbers;
    }
}
