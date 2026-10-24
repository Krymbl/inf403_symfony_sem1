<?php

declare(strict_types=1);

namespace App\Enum;

enum Role: int
{
    case USER = 1;

    public function getTitle(): string
    {
        return match ($this) {
            self::USER => 'User',
        };
    }
}
