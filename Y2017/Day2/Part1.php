<?php

namespace Netiul\AoC\Y2017\Day2\Part1;

$filenames = [
    dirname(__FILE__) . '/SpreadsheetData/Part1Example.aoc',
    dirname(__FILE__) . '/SpreadsheetData/SpreadsheetData.aoc',
];

foreach ($filenames as $filename) {
    echo Checksum::check($filename);
}

class Checksum
{
    /**
     * @param string $filename
     * @return ChecksumResult
     */
    public static function check(string $filename): ChecksumResult
    {
        $spreadsheetRows = self::readDataFromFile($filename);
        $maxDifferences = self::determineMaxDifferencePerRow($spreadsheetRows);

        $checksum = self::calculateChecksum($maxDifferences);

        return new ChecksumResult($spreadsheetRows, $checksum);
    }

    /**
     * @param string $filename
     * @return array
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
     * @return array
     */
    private static function determineMaxDifferencePerRow(array $spreadsheetRows): array
    {
        $maxDifferences = [];

        foreach ($spreadsheetRows as $spreadsheetRow) {
            $maxDifferences[] = max($spreadsheetRow) - min($spreadsheetRow);
        }

        return $maxDifferences;
    }

    /**
     * @param array $maxDifferences
     * @return int
     */
    private static function calculateChecksum(array $maxDifferences): int
    {
        return array_sum($maxDifferences);
    }
}

class ChecksumResult
{
    /**
     * @var array
     */
    private $spreadSheetData;

    /**
     * @var int
     */
    private $checksum;

    /**
     * @param array $data
     * @param int $checksum
     */
    public function __construct(array $data, int $checksum)
    {
        $this->spreadSheetData = $data;
        $this->checksum = $checksum;
    }

    /**
     * @return int
     */
    public function getChecksum(): int
    {
        return $this->checksum;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $spreadSheetData = $this->spreadSheetData;
        $spreadsheetRow1 = implode("\t", array_shift($spreadSheetData));
        array_walk($spreadSheetData, function (&$spreadsheetRow) {
            $spreadsheetRow = str_repeat(' ', 23) . implode("\t", $spreadsheetRow);
        });
        $checksum = $this->checksum;

        return "\n" . str_repeat("=", 120) . "\n" .
            "Spreadsheet:           $spreadsheetRow1\n" . implode("\n", $spreadSheetData). "\n" .
            "Checksum:              $checksum\n";
    }
}
