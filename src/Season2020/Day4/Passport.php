<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day4;

use function explode;
use function in_array;
use function preg_match;
use function str_replace;
use const PHP_EOL;

final class Passport
{
    private const BYR = 'byr';
    private const IYR = 'iyr';
    private const EYR = 'eyr';
    private const HGT = 'hgt';
    private const HCL = 'hcl';
    private const ECL = 'ecl';
    private const PID = 'pid';
    private const REQUIRED = [
        self::BYR,
        self::IYR,
        self::EYR,
        self::HGT,
        self::HCL,
        self::ECL,
        self::PID,
    ];

    /**
     * @var string[]
     */
    private $credentials;


    public function __construct(string $passportCredentials)
    {
        $normalizedCredentials = str_replace(PHP_EOL, ' ', $passportCredentials);

        $credentials = explode(' ', $normalizedCredentials);

        $this->credentials = [];
        foreach ($credentials as $definition) {
            $parts = explode(':', $definition);
            $this->credentials[$parts[0]] = $parts[1];
        }
    }


    public function hasCredential(string $key): bool
    {
        return isset($this->credentials[$key]);
    }


    public function hasAllCredentials(): bool
    {
        foreach (self::REQUIRED as $key) {
            if (!$this->hasCredential($key)) {
                return false;
            }
        }

        return true;
    }


    public function isValid(): bool
    {
        foreach ($this->getCredentialsValidators() as $key => $validator) {
            if (!$validator($this->credentials[$key])) {
                return false;
            }
        }

        return true;
    }


    private function getCredentialsValidators(): array
    {
        return [
            self::BYR => function (string $value): bool {
                $year = (int)$value;

                return $year >= 1920 && $year <= 2002;
            },
            self::IYR => function (string $value): bool {
                $year = (int)$value;

                return $year >= 2010 && $year <= 2020;
            },
            self::EYR => function (string $value): bool {
                $year = (int)$value;

                return $year >= 2020 && $year <= 2030;
            },
            self::HGT => function (string $value): bool {
                preg_match('/(\d+)(cm|in)/', $value, $height);

                if (count($height) !== 3) {
                    return false;
                }

                $number = $height[1];

                if ($height[2] === 'cm' && $number >= 150 && $number <= 193) {
                    return true;
                }

                if ($height[2] === 'in' && $number >= 59 && $number <= 76) {
                    return true;
                }

                return false;
            },
            self::HCL => function (string $value): bool {
                return preg_match('/^\#[a-f0-9]{6}$/', $value) === 1;
            },
            self::ECL => function (string $value): bool {
                return in_array($value, ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth']);
            },
            self::PID => function (string $value): bool {
                return preg_match('/^\d{9}$/', $value) === 1;
            },
        ];
    }
}
