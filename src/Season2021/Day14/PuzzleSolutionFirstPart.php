<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day14;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function explode;
use function preg_match;
use const PHP_EOL;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    /**
     * @var array<string, string>
     */
    private array $rules;

    private string $polymer;


    public function __construct()
    {
        $input = new LinesInput(__DIR__ . '/input.txt', PHP_EOL . PHP_EOL);

        $this->polymer = $input->getLines()[0];
        $this->rules = $this->loadRules($input->getLines()[1]);
    }


    public function getResult(): Result
    {
        $result = PolymerCycleAnalyzer::analyze($this->polymer, $this->rules, 10);

        return new IntegerResult($result['max'] - $result['min']);
    }


    private function loadRules(string $rules): array
    {
        $lines = explode(PHP_EOL, $rules);

        $replaces = [];

        foreach ($lines as $line) {
            preg_match('/(?<from>.*) -> (?<replace>.)/', $line, $result);

            $replaces[$result['from']] = $result['replace'];
        }

        return $replaces;
    }
}
