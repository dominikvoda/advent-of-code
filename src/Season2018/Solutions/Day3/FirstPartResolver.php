<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Solutions\Day3;

use AdventOfCode\Season2018\Solutions\InputReader;
use AdventOfCode\Season2018\Solutions\ResolverInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function array_map;
use function explode;
use function range;

class FirstPartResolver implements ResolverInterface
{
    public function resolve(string $input, OutputInterface $output): string
    {
        $inputData = array_map(
            function (string $line): array {
                preg_match('/#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/', $line, $output);

                $x = range($output[2], $output[2] + $output[4] - 1);
                $y = range($output[3], $output[3] + $output[5] - 1);

                $coordinates = [];

                foreach ($x as $row) {
                    foreach ($y as $column) {
                        $coordinates[] = $row . '-' . $column;
                    }
                }

                return $coordinates;
            },
            InputReader::readAsLines($input)
        );

        $fabric = [];
        $total = 0;

        foreach ($inputData as $coordinates) {
            foreach ($coordinates as $coordinate) {
                $parts = explode('-', $coordinate);

                if (isset($fabric[$parts[0]][$parts[1]])) {
                    $fabric[$parts[0]][$parts[1]]++;
                    $total++;
                    continue;
                }

                $fabric[$parts[0]][$parts[1]] = 1;
            }
        }

        return (string)$total;
    }
}
