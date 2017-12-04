<?php

namespace Netiul\AoC\Y2017\Day4\Part1;

$datafiles = [
    __DIR__ . '/Data/DataSet1.aoc',
    __DIR__ . '/Data/DataSet2.aoc',
];

foreach ($datafiles as $datafile) {
    $dataset = array_map('trim', file($datafile));

    echo PassPhraseValidator::validate($dataset);
}

class PassPhraseValidator
{
    /**
     * @var array
     */
    private $dataset;

    /**
     * @var array
     */
    private $validationResult;

    /**
     * @param array $dataset
     * @param array $validationResult
     */
    public function __construct(array $dataset, array $validationResult)
    {
        $this->dataset = $dataset;
        $this->validationResult = $validationResult;
    }

    /**
     * @param array $dataset
     * @return PassPhraseValidator
     */
    public static function validate(array $dataset)
    {
        $validationResult = [];

        foreach ($dataset as $passphrase) {
            $validationResult[] = self::validatePassphrase(trim($passphrase));
        }

        return new self($dataset, $validationResult);
    }

    /**
     * @param string $passphrase
     * @return int
     */
    private static function validatePassphrase(string $passphrase): int
    {
        $words = explode(' ', $passphrase);

        return (int) count(array_keys(array_count_values($words), 1, true)) === count($words);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $dataset = $this->dataset;
        $validationResult = $this->validationResult;

        $countValid = count(array_keys($validationResult, 1));

        return "\n" . implode("\n", array_map(function (string $passphrase, bool $isValid) {
                $color = $isValid ? "\e[32m" : "\e[31m";
                $valid = $isValid ? 'valid' : 'invalid';
                return $passphrase . ": $color$valid\e[0m";
            }, $dataset, $validationResult)) . "\n\nFound $countValid valid passphrases in the dataset\n";
    }
}
