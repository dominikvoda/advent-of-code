<?php declare(strict_types = 1);

namespace AdventOfCode\Season2020\Day16;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use Nette\Utils\Strings;
use function array_filter;
use function array_flip;
use function array_map;
use function array_product;
use function array_shift;
use function explode;
use function preg_match_all;
use function range;
use const PHP_EOL;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    /**
     * @var Fields
     */
    private $fields;

    /**
     * @var Ticket[]
     */
    private $validTickets;

    /**
     * @var int[]
     */
    private $myTicketNumbers;

    /**
     * @var int[]
     */
    private $unresolvedFieldIndexes;


    public function __construct()
    {
        $input = new LinesInput(__DIR__ . '/input.txt', PHP_EOL . PHP_EOL);
        preg_match_all('/(\d+)/', $input->getLines()[1], $myTicketNumbers);

        $this->fields = new Fields($input->getLines()[0]);
        $this->myTicketNumbers = array_map('intval', $myTicketNumbers[0]);
        $this->validTickets = $this->getValidNearbyTickets($input->getLines()[2]);
        $this->unresolvedFieldIndexes = range(0, $this->validTickets[0]->getSize() - 1);
    }


    public function getResult(): Result
    {
        $departureFieldIndexes = [];
        while ($this->unresolvedFieldIndexes !== []) {
            foreach ($this->unresolvedFieldIndexes as $unresolvedIndex) {
                $field = $this->fields->findField($this->getAllTicketNumberByField($unresolvedIndex));

                if ($field === null) {
                    continue;
                }

                unset($this->unresolvedFieldIndexes[$unresolvedIndex]);

                if (Strings::startsWith($field['name'], 'departure')) {
                    $departureFieldIndexes[] = $unresolvedIndex;
                }
            }
        }

        $myDepartureNumbers = array_intersect_key($this->myTicketNumbers, array_flip($departureFieldIndexes));

        return new IntegerResult(array_product($myDepartureNumbers));
    }


    private function getValidNearbyTickets(string $nearbyTickets): array
    {
        $tickets = explode(PHP_EOL, $nearbyTickets);
        array_shift($tickets);

        $nearbyTickets = array_map(
            static function (string $ticketData): Ticket {
                return Ticket::createFromString($ticketData);
            },
            $tickets
        );

        return array_filter(
            $nearbyTickets,
            function (Ticket $ticket): bool {
                return $ticket->isValid($this->fields);
            }
        );
    }


    private function getAllTicketNumberByField(int $fieldIndex): array
    {
        return array_map(
            static function (Ticket $ticket) use ($fieldIndex): int {
                return $ticket->getNumber($fieldIndex);
            },
            $this->validTickets
        );
    }
}
