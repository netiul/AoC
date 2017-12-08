<?php

namespace Netiul\AoC\Y2017\Day8\Part1;

class Registry
{
    /**
     * @var array
     */
    private $registry;

    public function __construct()
    {
        $this->registry = [];
    }

    /**
     * @return array
     */
    public function getRegistry(): array
    {
        return $this->registry;
    }

    /**
     * @param array $instruction
     * @return void
     */
    public function instruct(array $instruction)
    {
        $oName = $instruction['oName'];
        $oAmount = $instruction['oAmount'];
        $cName = $instruction['cName'];
        $cAmount = $instruction['cAmount'];

        if (!isset($this->registry[$oName])) {
            $this->registry[$oName] = 0;
        }
        if (!isset($this->registry[$cName])) {
            $this->registry[$cName] = 0;
        }

        switch ($instruction['cOperator']) {
            case '==':
                if (($this->registry[$cName] === $cAmount)) break;
                return;
            case '!=':
                if (($this->registry[$cName] !== $cAmount)) break;
                return;
            case '>';
                if (($this->registry[$cName] > $cAmount)) break;
                return;
            case '<';
                if (($this->registry[$cName] < $cAmount)) break;
                return;
            case '<=':
                if (($this->registry[$cName] <= $cAmount)) break;
                return;
            case '>=':
                if (($this->registry[$cName] >= $cAmount)) break;
                return;
        }

        $this->registry[$oName] += $oAmount;
    }

    /**
     * @param array $instructions
     */
    public function batchInstruct(array $instructions)
    {
        foreach ($instructions as $instruction) {
            $this->instruct($instruction);
        }
    }

    /**
     * @return int
     */
    public function getLargestValue(): int
    {
        return max($this->registry);
    }
}
