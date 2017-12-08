<?php

namespace Netiul\AoC\Y2017\Day7\Part2;

class UnbalancedProgramException extends \Exception
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $problemWeight;

    /**
     * @var int
     */
    private $correctWeight;

    /**
     * @param string $name
     * @param int $problemWeight
     * @param int $correctWeight
     */
    public function __construct(string $name, int $problemWeight, int $correctWeight)
    {
        $this->name = $name;
        $this->problemWeight = $problemWeight;
        $this->correctWeight = $correctWeight;

        parent::__construct('Found unbalanced program');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getProblemWeight(): int
    {
        return $this->problemWeight;
    }

    /**
     * @return int
     */
    public function getCorrectWeight(): int
    {
        return $this->correctWeight;
    }
}

class ProcessBalanceValidator
{
    /**
     * @var array
     */
    private $processList;

    /**
     * @var string
     */
    private $unbalancedProgramName;

    /**
     * @var int
     */
    private $problemWeight;

    /**
     * @var int
     */
    private $correctWeight;

    /**
     * @param array $processList
     * @param string $programName
     * @param int $problemWeight
     * @param int $correctWeight
     */
    public function __construct(array $processList, string $programName = null, int $problemWeight = null, int $correctWeight = null)
    {
        $this->processList = $processList;
        $this->unbalancedProgramName = $programName;
        $this->problemWeight = $problemWeight;
        $this->correctWeight = $correctWeight;
    }

    /**
     * @param array $tree
     * @return ProcessBalanceValidator
     */
    public static function validator(array $tree): self
    {
        try {
            self::validateSubTreeBalance($tree);
        } catch (UnbalancedProgramException $ex) {
            return new self($tree, $ex->getName(), $ex->getProblemWeight(), $ex->getCorrectWeight());
        }

        return new self($tree);
    }

    /**
     * @param array $tree
     * @return int
     * @throws UnbalancedProgramException
     */
    private static function validateSubTreeBalance(array $tree): int
    {
        $names = [];
        $subTotals = [];

        foreach ($tree['children'] as $child) {
            $names[] = $child['name'];
            $subTotals[] = self::validateSubTreeBalance($child);
        }

        $v = array_count_values($subTotals);
        if (count($v) > 1) {
            $k = array_search(1, $v, true);
            $j = array_search($k, $subTotals, true);
            $problemWeight = $tree['children'][$j]['weight'];
            $d = array_diff($subTotals, array($k));
            $correctWeight = $problemWeight - ($k - array_shift($d));
            throw new UnbalancedProgramException($names[$j], $problemWeight, $correctWeight);
        }

        return array_sum($subTotals) + $tree['weight'];
    }

    /**
     * @param array $base
     * @param array $children
     * @param array $names
     */
    private static function process(array &$base, array &$children, array $names)
    {
        foreach ($children as &$child) {
            if (!is_string($child)) continue;
            $k = array_search($child, $names, true);
            $child = $base[$k];
            unset($base[$k]);
            self::process($base, $child['children'], $names);
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $processList = $this->processList;
        $rootProcessName = $processList['name'];
        $unbalancedProgramName = $this->unbalancedProgramName;
        $problemWeight = $this->problemWeight;
        $correctWeight = $this->correctWeight;

        return "\nThe bottom program (root process) is named \e[31m$rootProcessName\e[0m and the unbalanced program is named \e[31m$unbalancedProgramName\e[0m. It's weight is \e[31m$problemWeight\e[0m, but it should weight \e[31m$correctWeight\e[0m.\n";
    }
}
