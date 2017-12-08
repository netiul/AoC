<?php

namespace Netiul\AoC\Y2017\Day7\Part1;

class RootProcessResolver
{
    /**
     * @var array
     */
    private $processList;

    /**
     * @param array $processList
     */
    public function __construct(array $processList)
    {
        $this->processList = $processList;
    }

    /**
     * @return array
     */
    public function getProcessList(): array
    {
        return $this->processList;
    }

    /**
     * @param array|int[] $processResponses
     * @return RootProcessResolver
     */
    public static function find(array $processResponses): self
    {
        $processes = self::parse($processResponses);
        $processNames = array_column($processes, 'name');

        foreach ($processes as &$process) {
            self::process($processes, $process['children'], $processNames);
        }

        return new self(array_shift($processes));
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
     * @param array $processResponses
     * @return array
     */
    private static function parse(array $processResponses): array
    {
        $processes = [];

        foreach ($processResponses as $processResponse) {
            preg_match_all('/(?P<name>[a-z]+) \((?P<weight>\d+)\)(?: ->(?P<children>(?: [a-z]+,?)+))?/', $processResponse, $matches);
            $processes[] = [
                'name' => $matches['name'][0],
                'weight' => (int) $matches['weight'][0],
                'children' => !empty($matches['children'][0]) ? array_map('trim', explode(',', $matches['children'][0])) : [],
            ];
        }

        return $processes;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $processList = $this->processList;
        $rootProcessName = $processList['name'];

        return "\nThe bottom program (root process) is named \e[31m$rootProcessName\e[0m.\n";
    }
}
