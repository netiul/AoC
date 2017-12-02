<?php

namespace Netiul\AoC\Y2017\Day2\Part2;

$filenames = [
    dirname(__FILE__) . '/SpreadsheetData/Part2Example.aoc',
    dirname(__FILE__) . '/SpreadsheetData/SpreadsheetData.aoc',
];

foreach ($filenames as $filename) {
    echo EvenDivisibleNumberResolver::resolve($filename);
}

class EvenDivisibleNumberResolver
{
    /**
     * @param string $filename
     * @return EvenDivisibleNumberResolverResult
     */
    public static function resolve(string $filename): EvenDivisibleNumberResolverResult
    {
        $spreadsheetRows = self::readDataFromFile($filename);
        $pairs = self::resolveEvenDivisibleValuePairs($spreadsheetRows);

        $sum = self::calculateSumOfResults($pairs);

        return new EvenDivisibleNumberResolverResult($spreadsheetRows, $pairs, $sum);
    }

    /**
     * @param string $filename
     * @return array|array[]
     */
    private static function readDataFromFile(string $filename): array
    {
        $rows = file($filename);

        array_walk($rows, function (&$row) {
            $row = explode("\t", $row);
            array_walk($row, function (&$value) {
                $value = (int) $value;
            });
        });

        return $rows;
    }

    /**
     * @param array $spreadsheetRows
     * @return array|array[]
     */
    private static function resolveEvenDivisibleValuePairs(array $spreadsheetRows): array
    {
        $evenDivisibleValuePairs = [];

        foreach ($spreadsheetRows as $spreadsheetRow) {
            sort($spreadsheetRow);
            $evenDivisibleValuePairs[] = self::resolveEvenDivisableValuePair($spreadsheetRow);
        }

        return $evenDivisibleValuePairs;
    }

    /**
     * @param array $spreadsheetRow
     * @return array|int[]
     */
    private static function resolveEvenDivisableValuePair(array $spreadsheetRow): array
    {
        $copySpreadsheetRow = array_reverse($spreadsheetRow);

        do {
            $referenceValue = array_shift($copySpreadsheetRow);
            foreach ($spreadsheetRow as $divider) {
                if ($divider === $referenceValue) continue;
                $modulus = $referenceValue % $divider;
                if ($modulus === 0) return [$referenceValue, $divider];
            }
        } while(true);

        return [];
    }

    /**
     * @param array $divisiblePairs
     * @return int
     */
    private static function calculateSumOfResults(array $divisiblePairs): int
    {
        return array_sum(array_map(function ($pair) {
            return $pair[0] / $pair[1];
        }, $divisiblePairs));
    }
}

class EvenDivisibleNumberResolverResult
{
    /**
     * @var array
     */
    private $spreadsheetData;

    /**
     * @var array
     */
    private $pairs;

    /**
     * @var int
     */
    private $sum;

    /**
     * @param array $spreadsheetData
     * @param array $pairs
     * @param int $sum
     */
    public function __construct(array $spreadsheetData, array $pairs, int $sum)
    {
        $this->spreadsheetData = $spreadsheetData;
        $this->pairs = $pairs;
        $this->sum = $sum;
    }

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->sum;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $spreadsheetData = $this->spreadsheetData;

        $formattedSpreadsheetData = array_map(function($row, $pair) {
            $highKey = array_search($pair[0], $row);
            $row[$highKey] = "\e[31m" . $row[$highKey] . "\e[0m";
            $lowKey = array_search($pair[1], $row);
            $row[$lowKey] = "\e[31m" . $row[$lowKey] . "\e[0m";
            return $row;
        }, $spreadsheetData, $this->pairs);

        $spreadsheetRow1 = implode("\t", array_shift($spreadsheetData));
        $formattedSpreadsheetRow1 = implode("\t", array_shift($formattedSpreadsheetData));

        array_walk($spreadsheetData, function (&$spreadsheetRow) {
            $spreadsheetRow = str_repeat(' ', 23) . implode("\t", $spreadsheetRow);
        });

        array_walk($formattedSpreadsheetData, function (&$spreadsheetRow) {
            $spreadsheetRow = str_repeat(' ', 23) . implode("\t", $spreadsheetRow);
        });

        $sum = $this->sum;

        return "\n" . str_repeat("=", 120) . "\n" .
            "Spreadsheet:           $spreadsheetRow1\n" . implode("\n", $spreadsheetData). "\n" .
            "Formatted spreadsheet: $formattedSpreadsheetRow1\n" . implode("\n", $formattedSpreadsheetData). "\n" .
            "Sum:                   $sum\n";
    }
}
