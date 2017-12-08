<?php

namespace Netiul\AoC\Y2017\Day8\Part1;

class RegistryInstructionParser
{
    /**
     * @param string $instruction
     * @return array
     */
    public static function parse(string $instruction): array
    {
        preg_match('/(?P<oName>\w+) (?P<oOperator>\w+) (?P<oAmount>-?\d+) if (?P<cName>\w+) (?P<cOperator>(?:<|!)=?|(?:>|=)=?) (?P<cAmount>-?\d+)/', $instruction, $matches);

        return [
            'oName' => $matches['oName'],
            'oAmount' => $matches['oOperator'] == 'inc' ? 0 + (int) $matches['oAmount'] : 0 - (int) $matches['oAmount'],
            'cName' => $matches['cName'],
            'cOperator' => $matches['cOperator'],
            'cAmount' => (int) $matches['cAmount'],
        ];
    }
}
