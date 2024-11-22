<?php

namespace App\Enums;

enum Role: string
{
    case PASSENGER = 'PASSENGER';
    case DRIVER = 'DRIVER';
    case ADMIN = 'ADMIN';
}
