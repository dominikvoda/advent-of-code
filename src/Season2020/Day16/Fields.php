<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day16;

use function array_diff;
use function array_merge;
use function count;
use function explode;
use function preg_match;
use function range;
use const PHP_EOL;

final class Fields
{
    /**
     * @var int[]
     */
    private $allValidNumbers;

    /**
     * @var array
     */
    private $fields;


    public function __construct(string $allFieldsInput)
    {
        $this->allValidNumbers = [];
        $this->fields = [];

        $allFields = explode(PHP_EOL, $allFieldsInput);

        foreach ($allFields as $fieldLine) {
            $this->createField($fieldLine);
        }
    }


    /**
     * @return int[]
     */
    public function getAllValidNumbers(): array
    {
        return $this->allValidNumbers;
    }


    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }


    public function findField(array $numbers): ?array
    {
        $matchedFields = [];
        foreach ($this->fields as $index => $field) {
            if (array_diff($numbers, $field['validNumbers']) === []) {
                $matchedFields[] = $index;
            }
        }

        if (count($matchedFields) === 1) {
            $field = $this->fields[$matchedFields[0]];
            unset($this->fields[$matchedFields[0]]);

            return $field;
        }

        return null;
    }


    private function createField(string $fieldLine): void
    {
        preg_match('/(.+): (\d+)-(\d+) or (\d+)-(\d+)/', $fieldLine, $output_array);

        $validNumbers = array_merge(
            range((int)$output_array[2], (int)$output_array[3]),
            range((int)$output_array[4], (int)$output_array[5])
        );

        $this->fields[] = [
            'name' => $output_array[1],
            'validNumbers' => $validNumbers,
        ];

        $this->allValidNumbers = array_merge($this->allValidNumbers, $validNumbers);
    }
}
