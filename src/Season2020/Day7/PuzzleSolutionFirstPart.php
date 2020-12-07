<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day7;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_unique;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        /** @var BagRule[] $bagRules */
        $bagRules = LinesInput::createAsObjects(__DIR__ . '/input.txt', BagRule::class);

        $possibleBags = [];
        $colorsToFind = ['shiny gold'];

        while (true) {
            $nextColorsToFind = [];

            foreach ($bagRules as $bagDefinition) {
                foreach ($colorsToFind as $color) {
                    if ($bagDefinition->canContain($color)) {
                        $possibleBags[] = $bagDefinition->getColor();
                        $nextColorsToFind[] = $bagDefinition->getColor();
                    }
                }
            }

            if ($nextColorsToFind === []) {
                return IntegerResult::fromArrayCount(array_unique($possibleBags));
            }

            $colorsToFind = $nextColorsToFind;
        }
    }
}
