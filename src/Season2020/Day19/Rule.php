<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day19;

use Nette\Utils\Strings;
use function array_map;
use function array_unique;
use function assert;
use function explode;
use function implode;
use function in_array;
use function preg_match;
use function str_replace;

final class Rule
{
    /**
     * @var string
     */
    private $rule;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string[]
     */
    private $possibleValues;

    /**
     * @var int[]
     */
    private $missingRuleIds;


    public function __construct(string $line)
    {
        preg_match('/(\d+): (.*)/', $line, $matches);
        $this->id = (int)$matches[1];
        $this->possibleValues = $this->createPossibleValues($matches[2]);
        $this->recountMissingRuleIds();
    }


    private function createPossibleValues(string $rule): array
    {
        preg_match('/[a-z]/', $rule, $matches);
        if ($matches !== []) {
            return [$matches[0]];
        }

        if (!Strings::contains($rule, ' | ')) {
            return [$this->normalizeValue($rule)];
        }

        $parts = explode(' | ', $rule);

        return array_map([$this, 'normalizeValue'], $parts);
    }


    public function hasPlaceholder(): bool
    {
        return $this->missingRuleIds !== [];
    }


    public function replace(Rule $rule): void
    {
        assert(!$rule->hasPlaceholder());

        if (!in_array($rule->getId(), $this->missingRuleIds, true)) {
            return;
        }

        $newPossibleValues = [];

        foreach ($this->possibleValues as $possibleValue) {
            foreach ($rule->getPossibleValues() as $rulePossibleValue) {
                $search = $this->normalizeValue((string)$rule->getId());
                $replace = $this->normalizeValue($rulePossibleValue);
                $newPossibleValues[] = str_replace($search, $replace, $possibleValue);
            }
        }

        $this->possibleValues = array_unique($newPossibleValues);
        $this->recountMissingRuleIds();
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function recountMissingRuleIds(): void
    {
        $allRules = implode(' ', $this->possibleValues);
        preg_match_all('/\d+/', $allRules, $matches);

        $this->missingRuleIds = array_map('intval', $matches[0]);
    }


    /**
     * @return string[]
     */
    public function getPossibleValues(): array
    {
        return $this->possibleValues;
    }


    public function normalizeValue(string $value): string
    {
        $normalized = ' ' . $value . ' ';

        return str_replace('  ', ' ', $normalized);
    }
}
