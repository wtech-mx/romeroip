<?php

namespace App\Support;

class TrademarkOrigin
{
    public static function label(?string $origin): string
    {
        $value = trim((string) $origin);
        return [
            'nacional' => 'National', 'national' => 'National',
            'extranjero' => 'International', 'foreign' => 'International',
            'international' => 'International', 'internacional' => 'International',
            '-' => '',
        ][strtolower($value)] ?? $value;
    }
}
