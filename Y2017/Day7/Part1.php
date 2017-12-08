<?php

use Netiul\AoC\Y2017\Day7\Part1\RootProcessResolver;

include 'RootProcessResolver.php';

$datafiles = [
    __DIR__ . '/Data/Dataset1.aoc',
    __DIR__ . '/Data/Dataset2.aoc',
];

foreach ($datafiles as $datafile) {
    $processes = file($datafile);
    $processes = array_map('trim', $processes);

    echo "\n" . str_repeat("=", 120);
    echo RootProcessResolver::find($processes);
}
