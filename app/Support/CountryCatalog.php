<?php
namespace App\Support;

final class CountryCatalog
{
    public static function entries(bool $offices = false): array
    {
        static $catalogs = [];
        $key = $offices ? 'kept02_countries_territories_offices.csv' : 'kept01_countries_territories.csv';
        if (!isset($catalogs[$key])) {
            $handle = fopen(resource_path('data/'.$key), 'r');
            fgetcsv($handle);
            $entries = [];
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) >= 2) $entries[trim($row[1])] = trim($row[0]);
            }
            fclose($handle);
            uasort($entries, fn ($a, $b) => strcasecmp($a, $b));
            $catalogs[$key] = $entries;
        }
        return $catalogs[$key];
    }

    public static function code(?string $value, bool $offices = false): ?string
    {
        foreach (self::entries($offices) as $code => $name) {
            if (strcasecmp(trim((string) $value), $name) === 0 || strcasecmp(trim((string) $value), $code) === 0) return $code;
        }
        return null;
    }

    public static function label(?string $value, bool $offices = false): string
    {
        $code = self::code($value, $offices);
        return $code ? self::entries($offices)[$code] : (string) $value;
    }
}
