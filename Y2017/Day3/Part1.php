<?php

namespace Netiul\AoC\Y2017\Day3\Part1;

$numbers = [
    1,
    12,
    23,
    1024,
    312051,
];

foreach ($numbers as $number) {
    echo ManhattanDistance::solve($number);
}

class ManhattanDistance
{
    /**
     * @var int
     */
    private $number;

    /**
     * @var int
     */
    private $distance;

    /**
     * @return int
     */
    public function getDistance(): int
    {
        return $this->distance;
    }

    /**
     * @param int $number
     * @param int $distance
     */
    public function __construct(int $number, int $distance)
    {
        $this->number = $number;
        $this->distance = $distance;
    }

    /**
     * Logic by https://twitter.com/EsthervdSHU/status/937342441463648258
     *
     * @param int $number
     * @return ManhattanDistance
     */
    public static function solve(int $number): self
    {
        $i = ceil(sqrt($number));

        if ($i % 2 === 0) $i++;
        $i = ($i + 1) / 2;

        $xi = 2 * $i - 1;

        $corner = 0;
        $nextCorner = $xi * $xi;

        for ($j = 1; $j <= 4; $j++) {
            $corner = $nextCorner;
            $nextCorner = $xi * $xi - $j * ( $xi - 1 );

            if (($number <= $corner) && ($number >= $nextCorner)) {
                break;
            }
        }

        $k = ($corner + $nextCorner) / 2;

        $distance = $i - 1 + abs($k - $number);

        return new self($number, $distance);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $number = $this->number;
        $distance = $this->distance;

        return "\nManhattan distance for number \e[31m$number\e[0m is \e[31m$distance\e[0m.\n";
    }
}
