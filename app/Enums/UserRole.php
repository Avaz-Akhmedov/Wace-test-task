<?php

namespace App\Enums;

enum UserRole: string
{

    case BUYER = 'buyer';
    case INSTALLER = 'installer';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
