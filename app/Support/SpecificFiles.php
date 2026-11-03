<?php
namespace App\Support;

final class SpecificFiles
{
    /** Parse intervals without expanding large ranges into individual numbers. */
    public static function parse(string $text): array
    {
        if (trim($text) === '') return [];
        $ranges = [];
        foreach (explode(',', $text) as $part) {
            if (!preg_match('/^\s*([0-9]{1,10})\s*(?:-\s*([0-9]{1,10})\s*)?$/D', $part, $match)) {
                throw new \InvalidArgumentException('Use file numbers separated by commas or ranges, for example 1002, 1005-1008.');
            }
            $from = (int) $match[1];
            $to = isset($match[2]) ? (int) $match[2] : $from;
            if ($from < 1 || $to < $from || $to > 2147483647) {
                throw new \InvalidArgumentException('Use positive file numbers and ranges with From less than or equal to To.');
            }
            $ranges[] = [$from, $to];
        }
        return $ranges;
    }
}
