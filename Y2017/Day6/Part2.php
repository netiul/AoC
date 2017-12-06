<?php

namespace Netiul\AoC\Y2017\Day6\Part2;

$datafiles = [
    __DIR__ . '/Data/Dataset1.aoc',
    __DIR__ . '/Data/Dataset2.aoc',
];

foreach ($datafiles as $datafile) {
    $memoryBanks = explode("\t", file_get_contents($datafile));
    $memoryBanks = array_map(function ($blocks) {
        return (int) $blocks;
    }, $memoryBanks);

    echo MemoryRedistributor::redistribute($memoryBanks);
}

class MemoryRedistributor
{
    /**
     * @var int
     */
    private $startMemBankConfig;

    /**
     * @var int
     */
    private $endMemBankConfig;

    /**
     * @var int
     */
    private $cycles;

    /**
     * @param array $startMemBankConfig
     * @param array $endMemBankConfig
     * @param int $cycles
     */
    public function __construct(array $startMemBankConfig, array $endMemBankConfig, int $cycles)
    {
        $this->startMemBankConfig = $startMemBankConfig;
        $this->endMemBankConfig = $endMemBankConfig;
        $this->cycles = $cycles;
    }

    /**
     * @param array|int[] $memBankConfig
     * @return MemoryRedistributor
     */
    public static function redistribute(array $memBankConfig): self
    {
        $startMemBankConfig = $memBankConfig;
        $memBankConfigs = [];
        $dOrder = array_keys($memBankConfig);
        $startLoop = false;

        do {
            $memBankConfigs[] = $memBankConfig;
            $payload = max($memBankConfig);
            $mK = array_search($payload, $memBankConfig, true);
            $memBankConfig[$mK] = 0;
            $order = array_merge(array_slice($dOrder, $mK + 1), array_slice($dOrder, 0, $mK + 1));
            $o = reset($order);
            while ($payload > 0) {
                $memBankConfig[$o]++;
                $payload--;
                $o = next($order) !== false ? current($order) : reset($order);
            }
            if (array_search($memBankConfig, $memBankConfigs) !== false) {
                if ($startLoop === false) {
                    $startLoop = true;
                    $memBankConfigs = [];
                } else {
                    break;
                }
            }
        } while(true);

        return new self($startMemBankConfig, $memBankConfig, count($memBankConfigs));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $startMemBankConfig = implode(' ', $this->startMemBankConfig);
        $endMemBankConfig = implode(' ', $this->endMemBankConfig);
        $cycles = $this->cycles;

        return "\nStarting from \"\e[31m$startMemBankConfig\e[0m\", the size of the infinite loop after seeing configuration \"\e[31m$endMemBankConfig\e[0m\" for the 2nd time until I saw it again is \e[31m$cycles\e[0m cycles.\n";
    }
}
