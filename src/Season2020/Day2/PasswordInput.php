<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day2;

use function assert;
use function count;
use function preg_match;
use function substr_count;

final class PasswordInput
{
    /**
     * @var int
     */
    private $min;

    /**
     * @var int
     */
    private $max;

    /**
     * @var mixed
     */
    private $character;

    /**
     * @var mixed
     */
    private $password;


    public function __construct(string $inputLine)
    {
        preg_match('/(\d+)-(\d+) (.): (.*)/', $inputLine, $output);
        assert(count($output) === 5);

        $this->min = (int)$output[1];
        $this->max = (int)$output[2];
        $this->character = $output[3];
        $this->password = $output[4];
    }


    public function isValid(): bool
    {
        preg_match('/(\d+)-(\d+) (.): (.*)/', $this->min, $output);
        assert(count($output) === 5);

        $min = (int)$output[1];
        $max = (int)$output[2];
        $character = $output[3];
        $password = $output[4];

        $characterOccurrence = substr_count($password, $character);

        return $characterOccurrence >= $min && $characterOccurrence <= $max;
    }


    /**
     * @return int
     */
    public function getMin(): int
    {
        return $this->min;
    }


    /**
     * @return int
     */
    public function getMax(): int
    {
        return $this->max;
    }


    /**
     * @return mixed
     */
    public function getCharacter()
    {
        return $this->character;
    }


    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
}
