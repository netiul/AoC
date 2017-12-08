<?php

use Netiul\AoC\Y2017\Day8\Part1\Registry;
use Netiul\AoC\Y2017\Day8\Part1\RegistryInstructionParser;

include 'Registry.php';
include 'RegistryInstructionParser.php';

$datafiles = [
    __DIR__ . '/Data/Dataset1.aoc',
    __DIR__ . '/Data/Dataset2.aoc',
];

foreach ($datafiles as $datafile) {
    $instructions = file($datafile);
    $instructions = array_map('trim', $instructions);
    $instructions = array_map([RegistryInstructionParser::class, 'parse'], $instructions);

    $registry = new Registry();
    $largestValue = 0;
    $currentLargestValue = 0;
    foreach ($instructions as $instruction) {
        $registry->instruct($instruction);
        $currentLargestValue = $registry->getLargestValue();
        $largestValue = $currentLargestValue > $largestValue ? $currentLargestValue : $largestValue;
    }

    echo "\n" . str_repeat("=", 120);
    echo "\nLargest value held in any register during process is \e[31m$largestValue\e[0m, while the largest value after executing all instructions is \e[31m$currentLargestValue\e[0m.\n";
}
