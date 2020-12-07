<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day7;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    /**
     * @var BagRule[]
     */
    private $bagRules;


    public function getResult(): Result
    {
        /** @var BagRule[] $bagRules */
        $bagRules = LinesInput::createAsObjects(__DIR__ . '/input.txt', BagRule::class);

        $this->bagRules = [];

        foreach ($bagRules as $bagDefinition) {
            $this->bagRules[$bagDefinition->getColor()] = $bagDefinition;
        }

        return new IntegerResult($this->countContent($this->bagRules['shiny gold']) - 1);
    }


    private function countContent(BagRule $bagRule): int
    {
        $content = $bagRule->getContent();

        $total = 0;

        foreach ($content as $color => $amount) {
            $total += $amount * $this->countContent($this->bagRules[$color]);
        }

        return $total + 1;
    }
}
