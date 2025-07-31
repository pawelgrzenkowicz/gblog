<?php

declare(strict_types=1);

namespace App\Domain\Shared\Enum;

enum Role: string
{
    case SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    case PREMIUM_USER = 'ROLE_PREMIUM_USER';
    case ADVANCED_USER = 'ROLE_ADVANCED_USER';
    case FREE_USER = 'ROLE_FREE_USER';
}
