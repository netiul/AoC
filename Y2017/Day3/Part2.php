<?php

namespace Netiul\AoC\Y2017\Day3\Part2;

if (!isset($argv[1])) {
    echo "Provide number as first argument\n";
    exit(1);
}

echo SpiralSum::create($argv[1]);

class SpiralSum
{
    const D_RIGHT = 0;
    const D_UP = 1;
    const D_LEFT = 2;
    const D_DOWN = 3;

    /**
     * @var array
     */
    private $grid;

    /**
     * @param array $grid
     */
    public function __construct(array $grid)
    {
        $this->grid = $grid;
    }

    /**
     * @return array
     */
    public function getGrid(): array
    {
        return $this->grid;
    }

    /**
     * @param int $number
     * @return SpiralSum
     */
    public static function create(int $number): self
    {
        $x = 0;
        $y = 0;

        $grid = [
            $y => [
                $x => 1,
            ]
        ];

        $direction = self::D_RIGHT;

        $sum = $grid[$y][$x];

        while ($sum <= $number) {
            switch ($direction) {
                case self::D_RIGHT:
                    $x++;
                    $sum = $grid[$y][$x - 1] + ($grid[$y + 1][$x - 1] ?? 0) + ($grid[$y + 1][$x] ?? 0) + ($grid[$y + 1][$x + 1] ?? 0);
                    $direction = isset($grid[$y + 1][$x]) ? $direction : self::D_UP;
                    break;
                case self::D_UP:
                    $y++;
                    $sum = $grid[$y - 1][$x] + ($grid[$y - 1][$x - 1] ?? 0) + ($grid[$y][$x - 1] ?? 0) + ($grid[$y + 1][$x - 1] ?? 0);
                    $direction = isset($grid[$y][$x - 1]) ? $direction : self::D_LEFT;
                    break;
                case self::D_LEFT:
                    $x--;
                    $sum = $grid[$y][$x + 1] + ($grid[$y - 1][$x + 1] ?? 0) + ($grid[$y - 1][$x] ?? 0) + ($grid[$y - 1][$x - 1] ?? 0);
                    $direction = isset($grid[$y - 1][$x]) ? $direction : self::D_DOWN;
                    break;
                default: // self::D_DOWN
                    $y--;
                    $sum = $grid[$y + 1][$x] + ($grid[$y + 1][$x + 1] ?? 0) + ($grid[$y][$x + 1] ?? 0) + ($grid[$y - 1][$x + 1] ?? 0);
                    $direction = isset($grid[$y][$x + 1]) ? $direction : self::D_RIGHT;
                    break;
            }

            $grid[$y][$x] = $sum;
        }

        return new self($grid);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $grid = $this->grid;
        krsort($grid);

        $maxNumber = max(array_merge(...$grid));

        $cellLength = strlen((string) $maxNumber);
        $xAxisLength = max(array_map('count', $grid));
        $minY = min(array_keys($grid));

        return implode("\n", array_map(function ($row, $y) use ($cellLength, $xAxisLength, $minY) {
                ksort($row);

                return str_pad(implode(' ', array_map(function ($value) use ($cellLength) {
                    return str_pad($value, $cellLength , ' ');
                }, $row)), $xAxisLength * ($cellLength + 1) - 1, ' ', $y === $minY ? STR_PAD_RIGHT : STR_PAD_LEFT);
            }, $grid, array_keys($grid))) . "\n";
    }
}
