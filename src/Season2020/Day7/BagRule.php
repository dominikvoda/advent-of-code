<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day7;

use Nette\Utils\Strings;
use function array_key_exists;
use function explode;

final class BagRule
{
    /**
     * @var string
     */
    private $color;

    /**
     * @var array<string, int>
     */
    private $content;


    public function __construct(string $input)
    {
        preg_match('/^(.*) bags contain (.*)$/', $input, $instruction);
        $this->color = $instruction[1];
        $this->content = $this->resolveContent($instruction[2]);
    }


    private function resolveContent(string $contentInput): array
    {
        if (Strings::contains($contentInput, 'no other bags.')) {
            return [];
        }

        $contents = explode(', ', $contentInput);
        $result = [];

        foreach ($contents as $content) {
            preg_match('/^(\d+) (.*) (bag|bags)\.?$/', $content, $matches);
            $result[$matches[2]] = $matches[1];
        }

        return $result;
    }


    public function canContain(string $color): bool
    {
        return array_key_exists($color, $this->content);
    }


    /**
     * @return int[]
     */
    public function getContent(): array
    {
        return $this->content;
    }


    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }
}
