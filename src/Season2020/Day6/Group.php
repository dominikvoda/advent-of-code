<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day6;

use function array_intersect;
use function array_map;
use function array_merge;
use function array_unique;
use function count;
use function explode;
use const PHP_EOL;

final class Group
{
    /**
     * @var string[][]
     */
    private $allAnswers;


    public function __construct(string $input)
    {
        $lines = explode(PHP_EOL, $input);
        $this->allAnswers = array_map('str_split', $lines);
    }


    /**
     * @return int
     */
    public function getCombinedAnswersCount(): int
    {
        $combinedAnswers = array_unique(array_merge(...$this->allAnswers));

        return count($combinedAnswers);
    }


    /**
     * @return int
     */
    public function getYesAnswers(): int
    {
        $sameAnswers = count($this->allAnswers) === 1 ? $this->allAnswers[0] : array_intersect(...$this->allAnswers);

        return count($sameAnswers);
    }
}
