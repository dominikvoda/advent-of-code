<?php

namespace AdventOfCode\Season2017\Days;

class Day4 extends DefaultDay
{
    /**
     * @return string
     */
    protected function getInputType(): string
    {
        return self::INPUT_LINES;
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveFirstPuzzle($input): string
    {
        $total = 0;
        /** @var string $line */
        foreach ($input as $line) {
            $words = $this->extractWordsFromLine($line);
            if ($this->isValidPassPhraseFirst($words)) {
                $total++;
            }
        }

        return $total;
    }

    /**
     * @param array|null|string $input
     *
     * @return string
     */
    protected function resolveSecondPuzzle($input): string
    {
        $total = 0;
        /** @var string $line */
        foreach ($input as $line) {
            $words = $this->extractWordsFromLine($line);
            if ($this->isValidPassPhraseSecond($words)) {
                $total++;
            }
        }

        return $total;
    }

    /**
     * @param $line
     *
     * @return array
     */
    private function extractWordsFromLine($line): array
    {
        return explode(' ', $line);
    }

    /**
     * @param array $words
     *
     * @return bool
     */
    private function isValidPassPhraseFirst(array $words): bool
    {
        while (count($words) > 0) {
            $word = array_pop($words);
            if (in_array($word, $words)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $words
     *
     * @return bool
     */
    private function isValidPassPhraseSecond(array $words): bool
    {
        $mapped = array_map(
            function ($item) {
                $chars = str_split($item);
                asort($chars);

                return implode('', $chars);
            },
            $words
        );

        while (count($mapped) > 0) {
            $word = array_pop($mapped);
            if (in_array($word, $mapped)) {
                return false;
            }
        }

        return true;
    }
}
