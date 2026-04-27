<?php

namespace App\Enums;

enum PartyStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';


    public function label()
    {
        return match ($this) {
            self::ACTIVE => 'faol',
            self::INACTIVE => 'nofaol',
        };
    }
}
