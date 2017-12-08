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
    $registry->batchInstruct($instructions);
    $largestValue = $registry->getLargestValue();

    echo "\n" . str_repeat("=", 120);
    echo "\nLargest value after executing instructions is \e[31m$largestValue\e[0m.\n";
}
