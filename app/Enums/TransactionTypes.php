<?php

namespace App\Enums;

enum TransactionTypes: string
{
    case Auction = 'Auction';
    case Lease = 'Lease';
    case Sale = 'Sale';
    case Investment = 'Investment';

    public static function toArray()
    {
        return [
            static::Auction->value,
            static::Lease->value,
            static::Sale->value,
            static::Investment->value
        ];
    }

    public static function toObject()
    {
        return [
            ['name' => 'Sale', 'value' => static::Sale->value],
            ['name' => 'Auction', 'value' => static::Auction->value],
            ['name' => 'Lease', 'value' => static::Lease->value],
            ['name' => 'Investment', 'value' => static::Investment->value]
        ];
    }
}
