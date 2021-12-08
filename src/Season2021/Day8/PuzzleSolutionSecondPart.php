<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day8;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use function array_diff;
use function array_map;
use function array_search;
use function implode;
use function range;
use function sort;
use function str_split;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    private const NUMBERS = [
        'abcefg' => 0,
        'cf' => 1,
        'acdeg' => 2,
        'acdfg' => 3,
        'bcdf' => 4,
        'abdfg' => 5,
        'abdefg' => 6,
        'acf' => 7,
        'abcdefg' => 8,
        'abcdfg' => 9,
    ];


    public function getResult(): Result
    {
        /** @var InputLine[] $inputLines */
        $inputLines = LinesInput::createAsObjects(__DIR__ . '/input.txt', InputLine::class);

        $total = 0;
        foreach ($inputLines as $inputLine) {
            $decoded = '';
            $result = $this->getCorrectWires($inputLine);

            foreach ($inputLine->getOutputs() as $output) {
                $translatedOutput = $this->translateOutput($result, $output);
                $decoded .= self::NUMBERS[$translatedOutput];
            }

            $total += (int)$decoded;
        }

        return new IntegerResult($total);
    }


    private function translateOutput(array $result, string $output): string
    {
        $decoded = [];
        foreach (str_split($output) as $char) {
            $decoded[] = array_search($char, $result, true);
        }
        sort($decoded);

        return implode('', $decoded);
    }


    private function getCorrectWires(InputLine $inputLine): array
    {
        $all = range('a', 'g');
        $aDiff = array_diff($inputLine->getSevenSegments(), $inputLine->getOneSegments());
        $a = end($aDiff);

        $result = [
            'a' => [$a => $a],
            'b' => [$inputLine->getBSegment() => $inputLine->getBSegment()],
            'c' => $this->generateOptions(),
            'd' => $this->generateOptions(),
            'e' => [$inputLine->getESegment() => $inputLine->getESegment()],
            'f' => [$inputLine->getFSegment() => $inputLine->getFSegment()],
            'g' => $this->generateOptions(),
        ];

        $result = $this->reduce($result, range('b', 'g'), $result['a']);
        $result = $this->reduce($result, array_diff($all, ['c', 'f']), $inputLine->getOneSegments());
        $result = $this->reduce($result, array_diff($all, ['a', 'c', 'f']), $inputLine->getSevenSegments());
        $result = $this->reduce($result, array_diff($all, ['b', 'd', 'c', 'f']), $inputLine->getFourSegments());
        $result = $this->reduce($result, array_diff($all, ['b']), [$inputLine->getBSegment()]);
        $result = $this->reduce($result, array_diff($all, ['e']), [$inputLine->getESegment()]);
        $result = $this->reduce($result, array_diff($all, ['f']), [$inputLine->getFSegment()]);
        $result = $this->reduce($result, array_diff($all, ['g']), $result['g']);
        $result = $this->reduce($result, array_diff($all, ['d']), $result['d']);

        return array_map(static function (array $result): string {
            return end($result);
        }, $result);
    }


    private function reduce(array $result, array $options, array $places): array
    {
        foreach ($options as $option) {
            foreach ($places as $place) {
                unset($result[$option][$place]);
            }
        }

        return $result;
    }


    private function generateOptions(): array
    {
        $range = range('a', 'g');
        $options = [];

        foreach ($range as $place) {
            $options[$place] = $place;
        }

        return $options;
    }
}
