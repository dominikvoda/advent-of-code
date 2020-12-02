<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Day5;

use AdventOfCode\Season2019\Intcode\Computer;
use AdventOfCode\Season2019\Intcode\Input;
use AdventOfCode\Season2019\Intcode\Output;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use function range;

class SecondPartTest extends TestCase
{
    /**
     * @dataProvider computerDataProvider
     */
    public function test(array $numbers, int $inputValue, int $expectedOutput): void
    {
        $output = new Output();
        $input = new Input($inputValue);
        $computer = new Computer($input, $output);

        $program = new ArrayCollection($numbers);

        $computer->run($program);

        Assert::assertEquals((string)$expectedOutput, $output->flush());
    }


    public function computerDataProvider(): array
    {
        $dataset = [];

        foreach (range(0, 15) as $input) {
            $dataset['ds1-input-' . $input] = [
                'numbers' => [3, 9, 8, 9, 10, 9, 4, 9, 99, -1, 8],
                'inputValue' => $input,
                'expectedOutput' => (int)($input === 8),
            ];
        }

        foreach (range(0, 15) as $input) {
            $dataset['ds2-input-' . $input] = [
                'numbers' => [3, 9, 7, 9, 10, 9, 4, 9, 99, -1, 8],
                'inputValue' => $input,
                'expectedOutput' => (int)($input < 8),
            ];
        }

        foreach (range(0, 15) as $input) {
            $dataset['ds3-input-' . $input] = [
                'numbers' => [3, 3, 1108, -1, 8, 3, 4, 3, 99],
                'inputValue' => $input,
                'expectedOutput' => (int)($input === 8),
            ];
        }

        foreach (range(0, 15) as $input) {
            $dataset['ds4-input-' . $input] = [
                'numbers' => [3, 3, 1107, -1, 8, 3, 4, 3, 99],
                'inputValue' => $input,
                'expectedOutput' => (int)($input < 8),
            ];
        }

        foreach (range(0, 15) as $input) {
            $dataset['ds5-input-' . $input] = [
                'numbers' => [3, 12, 6, 12, 15, 1, 13, 14, 13, 4, 13, 99, -1, 0, 1, 9],
                'inputValue' => $input,
                'expectedOutput' => (int)($input !== 0),
            ];
        }

        return $dataset;
    }
}
