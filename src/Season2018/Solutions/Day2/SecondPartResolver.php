<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Solutions\Day2;

use AdventOfCode\Season2018\Solutions\InputReader;
use AdventOfCode\Season2018\Solutions\ResolverInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function array_diff_assoc;
use function array_keys;
use function array_map;
use function count;
use function implode;
use function str_split;

class SecondPartResolver implements ResolverInterface
{
    public function resolve(string $input, OutputInterface $output): string
    {
        $inputLines = array_map(
            function (string $inputLine) {
                return str_split($inputLine);
            },
            InputReader::readAsLines($input)
        );

        foreach ($inputLines as $key => $inputLine) {
            unset($inputLines[$key]);

            foreach ($inputLines as $inputLineToCompare) {
                $arrayDiff = array_diff_assoc($inputLine, $inputLineToCompare);

                if (count($arrayDiff) === 1) {
                    $keys = array_keys($arrayDiff);

                    unset($inputLineToCompare[$keys[0]]);

                    return implode('', $inputLineToCompare);
                }
            }
        }

        return 'not found';
    }
}
