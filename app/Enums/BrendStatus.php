<?php

namespace App\Enums;

enum BrendStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';
    case BLOCKED = 'blocked';

    public function label()
    {
        return match ($this) {
            self::ACTIVE => 'Faol',
            self::INACTIVE => 'Nofaol',
            self::PENDING => 'Kutilmoqda',
            self::BLOCKED => 'Bloklangan',
        };
    }
}
