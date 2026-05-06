<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PAID = 'paid';
    case UNPAID = 'unpaid';

    public function label()
    {
        return match ($this) {
            self::UNPAID => "to'lanmagan",
            self::PAID => "to'langan",
        };
    }
}
