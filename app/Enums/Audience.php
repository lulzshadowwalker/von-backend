<?php

namespace App\Enums;

enum Audience: string
{
    case PASSENGERS = 'PASSENGERS';
    case DRIVERS = 'DRIVERS';
    case ALL = 'ALL';

    public function label(): string
    {
        return match ($this) {
            self::ALL => /**TRANSLATION*/ 'All',
            self::PASSENGERS => /**TRANSLATION*/ 'Passengers',
            self::DRIVERS => /**TRANSLATION*/ 'Drivers',
        };
    }
}
