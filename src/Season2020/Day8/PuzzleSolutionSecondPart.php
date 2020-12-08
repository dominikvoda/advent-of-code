<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day8;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;
use Nette\Utils\Strings;
use function str_replace;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $allInputs = $this->getAllInputs($input->getLines());

        foreach ($allInputs as $inputLine) {
            try {
                $accumulator = new Accumulator();

                Game::run($accumulator, $inputLine);

                return new IntegerResult($accumulator->getValue());
            } catch (InfiniteLoopException $exception) {
                continue;
            }
        }

        throw new LogicException('Oh no!');
    }


    private function getAllInputs(array $originInput): array
    {
        $total = count($originInput);

        $inputs = [];

        for ($i = 0; $i < $total; $i++) {
            $currentLine = $originInput[$i];

            if (Strings::contains($currentLine, 'acc')) {
                continue;
            }

            $newInput = $originInput;

            if (Strings::contains($currentLine, 'nop')) {
                $newInput[$i] = str_replace('nop', 'jmp', $currentLine);
                $inputs[] = $newInput;
                continue;
            }

            $newInput[$i] = str_replace('jmp', 'nop', $currentLine);
            $inputs[] = $newInput;
        }

        return $inputs;
    }
}
