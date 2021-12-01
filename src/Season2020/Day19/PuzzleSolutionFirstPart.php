<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day19;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_filter;
use function array_map;
use function count;
use function explode;
use function str_replace;
use const PHP_EOL;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    /**
     * @var Rule[]
     */
    private $rules;


    public function __construct()
    {
        $this->rules = [];
    }


    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt', PHP_EOL . PHP_EOL);

        foreach (explode(PHP_EOL, $input->getLines()[0]) as $ruleLine) {
            $rule = new Rule($ruleLine);
            $this->rules[$rule->getId()] = $rule;
        }

        $uncompletedRules = $this->getUncompletedRules();

        while ($uncompletedRules !== []) {
            foreach ($uncompletedRules as $uncompletedRule) {
                foreach ($this->getCompletedRules() as $completedRule) {
                    $uncompletedRule->replace($completedRule);
                }
            }

            $uncompletedRules = $this->getUncompletedRules();
            echo count($uncompletedRules) . PHP_EOL;
        }

        $zeroRule = $this->rules[0];

        $patterns = explode(PHP_EOL, $input->getLines()[1]);
        $rules = array_map(
            static function (string $pattern): string {
                return str_replace(' ', '', $pattern);
            },
            $zeroRule->getPossibleValues()
        );

        $total = 0;

        foreach ($patterns as $pattern) {
            foreach ($rules as $rule) {
                if (preg_match('/' . $rule . '/', $pattern) === 1) {
                    $total++;
                    break;
                }
            }
        }

        return new IntegerResult($total);
    }


    /**
     * @return Rule[]
     */
    private function getCompletedRules(): array
    {
        return array_filter(
            $this->rules,
            static function (Rule $rule): bool {
                return !$rule->hasPlaceholder();
            }
        );
    }


    /**
     * @return Rule[]
     */
    private function getUncompletedRules(): array
    {
        return array_filter(
            $this->rules,
            static function (Rule $rule): bool {
                return $rule->hasPlaceholder();
            }
        );
    }
}
