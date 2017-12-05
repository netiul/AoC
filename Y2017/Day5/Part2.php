<?php

namespace Netiul\AoC\Y2017\Day5\Part2;

$datafiles = [
    __DIR__ . '/Data/Dataset1.aoc',
    __DIR__ . '/Data/Dataset2.aoc',
];

foreach ($datafiles as $datafile) {
    $jumpInstructions = array_map('trim', file($datafile));
    $jumpInstructions = array_map(function ($v) {
        return (int) $v;
    }, $jumpInstructions);

    echo MemoryMazeJumper::jump($jumpInstructions);
}

class MemoryMazeJumper
{
    /**
     * @var int
     */
    private $oValue;

    /**
     * @var int
     */
    private $fValue;

    /**
     * @var int
     */
    private $steps;

    /**
     * @var int
     */
    private $exit;

    /**
     * @param int $oValue
     * @param int $fValue
     * @param int $steps
     * @param int $exit
     */
    public function __construct(int $oValue, int $fValue, int $steps, int $exit)
    {
        $this->oValue = $oValue;
        $this->fValue = $fValue;
        $this->steps = $steps;
        $this->exit = $exit;
    }

    /**
     * @param array|int[] $jumpInstructions
     * @return MemoryMazeJumper
     */
    public static function jump(array $jumpInstructions): self
    {
        $wJumpInstructions = $jumpInstructions;
        $steps = 0;
        $p = 0;
        $lastP = 0;

        while (isset($wJumpInstructions[$p])) {
            $lastP = $p;
            $jI = $jumpInstructions[$p];
            $jumpInstructions[$p] = $jumpInstructions[$p] + ($jI > 2 ? -1 : 1);
            $p += $jI;
            $steps++;
        }

        return new self($jumpInstructions[$lastP], $wJumpInstructions[$lastP], $steps, $lastP + 1);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $steps = $this->steps;
        $exit = $this->exit;
        $oValue = $this->oValue;
        $fValue = $this->fValue;

        return "\nExited the maze after \e[31m$steps\e[0m steps at position \e[31m$exit\e[0m with value \e[31m$oValue\e[0m (\e[31m$fValue\e[0m).\n";
    }
}
