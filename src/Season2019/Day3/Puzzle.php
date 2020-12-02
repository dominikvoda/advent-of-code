<?php declare(strict_types = 1);

namespace AdventOfCode\Season2019\Day3;

use AdventOfCode\Season2019\Input;
use AdventOfCode\Season2019\PuzzleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Nette\Utils\FileSystem;
use Nette\Utils\Json;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;
use function abs;
use function array_reverse;
use function array_shift;
use function max;
use function min;
use function preg_match;
use function range;
use function sprintf;
use function var_dump;

class Puzzle implements PuzzleInterface
{
    /**
     * @var OutputInterface
     */
    private $output;


    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }


    public function resolveFirstPart(): string
    {
        $lines = Input::linesFromFile(__DIR__ . '/input.txt');

        $lineA = Input::separatedBy($lines->first(), ',');
        $lineB = Input::separatedBy($lines->last(), ',');

        $coordinatesA = $this->createLine($lineA);
        $coordinatesB = $this->createLine($lineB);

        $distances = $this->getAllIntersections($coordinatesA, $coordinatesB)->map(
            static function (array $coordinate): int {
                return (int)abs($coordinate['x'] + (int)abs($coordinate['y']));
            }
        );
        $distances->removeElement(0);

        return (string)min($distances->toArray());
    }


    public function resolveSecondPart(): string
    {
        $lines = Input::linesFromFile(__DIR__ . '/input.txt');

        $lineA = Input::separatedBy($lines->first(), ',');
        $lineB = Input::separatedBy($lines->last(), ',');

        $coordinatesA = $this->createLine($lineA);
        $coordinatesB = $this->createLine($lineB);

        $this->render($coordinatesA, $coordinatesB);

        $distances = $this->getAllIntersections($coordinatesA, $coordinatesB)->map(
            static function (array $coordinate): int {
                return $coordinate['stepsA'] + $coordinate['stepsB'];
            }
        );

        $distances->removeElement(0);

        return (string)min($distances->toArray());
    }


    private function createLine($line): Collection
    {
        $startX = 0;
        $startY = 0;
        $steps = 0;

        $currentX = $startX;
        $currentY = $startY;
        $coordinates = new ArrayCollection();

        foreach ($line as $command) {
            $direction = $command[0];
            preg_match('/\d+/', $command, $numbers);
            $length = (int)$numbers[0];

            $startX = $currentX;
            $startY = $currentY;

            if ($direction === 'R') {
                $currentX += $length;
            }

            if ($direction === 'U') {
                $currentY -= $length;
            }

            if ($direction === 'L') {
                $currentX -= $length;
            }

            if ($direction === 'D') {
                $currentY += $length;
            }

            foreach ($this->getAllCoordinates($startX, $startY, $currentX, $currentY) as $item) {
                $key = $item['x'] . '_' . $item['y'];

                if ($coordinates->containsKey($key)) {
                    $steps = $coordinates->get($key)['s'];
                }

                $coordinates->set(
                    $key,
                    [
                        'x' => $item['x'],
                        'y' => $item['y'],
                        's' => $steps,
                    ]
                );

                $steps++;
            }
        }

        return $coordinates;
    }


    private function getAllCoordinates(int $startX, int $startY, int $nextX, int $nextY): array
    {
        $coordinates = [];

        if ($startX === $nextX) {
            $range = $this->getRange($startY, $nextY);

            foreach ($range as $item) {
                $coordinates[] = ['x' => $startX, 'y' => $item];
            }
        }

        if ($startY === $nextY) {
            $range = $this->getRange($startX, $nextX);

            foreach ($range as $item) {
                $coordinates[] = ['x' => $item, 'y' => $startY];
            }
        }

        return $coordinates;
    }


    private function getRange(int $start, int $next): array
    {
        $range = range(min([$start, $next]), max([$start, $next]));

        if ($start > $next) {
            return array_reverse($range);
        }

        return $range;
    }


    private function getAllIntersections(Collection $coordinatesA, Collection $coordinatesB): Collection
    {
        $progressBar = new ProgressBar($this->output);
        $progressBar->start($coordinatesB->count());
        $progressBar->setFormat('very_verbose');

        $crosses = new ArrayCollection();

        foreach ($coordinatesB as $key => $coordinateB) {
            if ($coordinatesA->containsKey($key)) {
                $crosses->add(
                    [
                        'x' => $coordinateB['x'],
                        'y' => $coordinateB['y'],
                        'stepsA' => $coordinatesA->get($key)['s'],
                        'stepsB' => $coordinateB['s'],
                    ]
                );
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->output->writeln('');

        return $crosses;
    }


    private function render(Collection $coordinatesA, Collection $coordinatesB): void
    {
        $axs = $coordinatesA->map(
            static function (array $coordinate): int {
                return $coordinate['x'];
            }
        )->toArray();

        $ays = $coordinatesA->map(
            static function (array $coordinate): int {
                return $coordinate['y'];
            }
        )->toArray();

        $bxs = $coordinatesB->map(
            static function (array $coordinate): int {
                return $coordinate['x'];
            }
        )->toArray();

        $bys = $coordinatesB->map(
            static function (array $coordinate): int {
                return $coordinate['y'];
            }
        )->toArray();

        $minXs = [min($axs), min($bxs)];
        $maxXs = [max($axs), max($bxs)];
        $minYs = [min($ays), min($bys)];
        $maxYs = [max($ays), max($bys)];

        $minX = min($minXs);
        $maxX = max($maxXs);
        $minY = min($minYs);
        $maxY = max($maxYs);

        $xOffset = -$minX;
        $yOffset = -$minY;

        $scale = 0.1;

        $width = $maxX + $xOffset;
        $height = $maxY + $yOffset;

        $output = '<svg width="' . $width * $scale . '" height="' . $height * $scale . '">';
        $output .= '<polyline style="fill:none;stroke:red;stroke-width:3" points="';

        foreach ($coordinatesA as $coordinate) {
            $output .= sprintf(
                '%d,%d ',
                ($coordinate['x'] + $xOffset) * $scale,
                ($coordinate['y'] + $yOffset) * $scale
            );
        }

        $output .= '"/>';

        $output .= '<polyline style="fill:none;stroke:blue;stroke-width:3" points="';

        foreach ($coordinatesB as $coordinate) {
            $output .= sprintf(
                '%d,%d ',
                ($coordinate['x'] + $xOffset) * $scale,
                ($coordinate['y'] + $yOffset) * $scale
            );
        }

        $output .= '"/>';
        $output .= '</svg>';

        FileSystem::write(__DIR__ . '/output/output.html', $output);

        FileSystem::write(
            __DIR__ . '/output/lines.json',
            Json::encode(
                [
                    'A' => $coordinatesA->toArray(),
                    'B' => $coordinatesB->toArray(),
                ]
            )
        );
    }
}
