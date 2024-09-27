<?php

namespace App\Enums;

enum BusinessTypes: string
{
    case Digital = 'digital';
    case Physical = 'physical';

    public static function toArray()
    {
        return [
            static::Digital->value,
            static::Physical->value,
        ];
    }
}
