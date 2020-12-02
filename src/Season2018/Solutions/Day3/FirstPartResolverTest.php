<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Solutions\Day3;

use Nette\Utils\FileSystem;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\NullOutput;

class FirstPartResolverTest extends TestCase
{
    public function testResolve(): void
    {
        $input = FileSystem::read(__DIR__ . '/test-input.txt');

        $resolver = new FirstPartResolver();

        $this->assertEquals(4, $resolver->resolve($input, new NullOutput()));
    }


    /**
     * @dataProvider inputLinesProvider
     */
    public function testRegexParsing(string $inputLine, array $expectedValues): void
    {
        preg_match('/#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/', $inputLine, $output);

        $this->assertEquals($expectedValues[0], $output[2]);
        $this->assertEquals($expectedValues[1], $output[3]);
        $this->assertEquals($expectedValues[2], $output[4]);
        $this->assertEquals($expectedValues[3], $output[5]);
    }


    public function inputLinesProvider(): array
    {
        return [
            ['#1 @ 10,30: 40x40', [10, 30, 40, 40]],
            ['#1362 @ 593,968: 10x20', [593, 968, 10, 20]],
            ['#1326 @ 49,695: 11x16', [49, 695, 11, 16]],
        ];
    }
}
