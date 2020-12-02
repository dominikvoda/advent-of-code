<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Solutions\Day4;

use AdventOfCode\Season2018\Solutions\ResolverInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FirstPartResolver implements ResolverInterface
{
    public function resolve(string $input, OutputInterface $output): string
    {
        $inputData = array_map(
        function (string $line): array {
            preg_match('/\[(.*)\] (.*)/', $line, $output);

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
    }
}
