<?php declare(strict_types = 1);

namespace AdventOfCode\Season2018\Solutions\Day1;

use AdventOfCode\Season2018\Solutions\InputReader;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Console\Output\OutputInterface;

class SecondPartResolver
{
    public function resolve(string $input, OutputInterface $output): string
    {
        $frequency = 0;

        $arrayInput = InputReader::readAsLines($input);

        $existing = new ArrayCollection([$frequency]);

        while (true) {
            foreach ($arrayInput as $change) {
                $frequency += (int)$change;

                if ($existing->contains($frequency)) {
                    return (string)$frequency;
                }

                $existing->add($frequency);
            }
        }

        return '';
    }
}
