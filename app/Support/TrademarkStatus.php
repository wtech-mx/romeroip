<?php

namespace App\Support;

class TrademarkStatus
{
    public static function key(?string $status): string
    {
        $status = strtolower(trim((string) $status));
        return [
            'registrado' => 'registered', 'registrada' => 'registered',
            'pendiente' => 'pending', 'abandonada' => 'abandoned', 'abandonado' => 'abandoned',
            'caduca' => 'lapsed', 'caduco' => 'lapsed', 'inactiva' => 'inactive', 'inactivo' => 'inactive',
        ][$status] ?? $status;
    }

    public static function label(?string $status): string
    {
        return ucfirst(self::key($status));
    }
}
