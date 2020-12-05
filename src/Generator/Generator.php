<?php declare(strict_types = 1);

namespace AdventOfCode\Generator;

use Nette\Utils\FileSystem;
use function is_file;
use function str_replace;

final class Generator
{
    public function generateSolutionClasses(int $season, int $dayNumber): void
    {
        $this->createInputFileIfNotExists($season, $dayNumber);

        $this->createSolutionClassIfNotExists($season, $dayNumber, 'First');
        $this->createSolutionClassIfNotExists($season, $dayNumber, 'Second');
    }


    private function createSolutionClassIfNotExists(int $season, int $dayNumber, string $part): void
    {
        $dayFolder = $this->getDayFolder($season, $dayNumber);

        $solutionFileName = $dayFolder . '/PuzzleSolution' . $part . 'Part.php';

        if (is_file($solutionFileName)) {
            return;
        }

        $templateFile = FileSystem::read(__DIR__ . '/puzzleSolution.php.template');

        $replacedTemplate = str_replace(
            ['{{season}}', '{{dayNumber}}', '{{part}}'],
            [$season, $dayNumber, $part],
            $templateFile
        );

        FileSystem::write($solutionFileName, $replacedTemplate);
    }


    private function createInputFileIfNotExists(int $season, int $dayNumber): void
    {
        $dayFolder = $this->getDayFolder($season, $dayNumber);

        $inputFile = $dayFolder . '/input.txt';

        if (!is_file($inputFile)) {
            FileSystem::write($inputFile, '');
        }
    }


    private function getDayFolder(int $season, int $dayNumber): string
    {
        return __DIR__ . '/../Season' . $season . '/Day' . $dayNumber;
    }
}
