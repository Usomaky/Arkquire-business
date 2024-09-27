<?php

namespace App\Enums;

enum PropertyTypes: string
{
    case Office = 'Rented office';
    case Shop = 'Shop';
    case Workspace = 'Workspace';
    case None = 'None';

    public static function toArray()
    {
        return [
            static::Office->value,
            static::Shop->value,
            static::Workspace->value,
            static::None->value
        ];
    }
}
