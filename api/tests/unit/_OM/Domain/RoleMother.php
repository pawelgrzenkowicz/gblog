<?php

declare(strict_types=1);

namespace App\Tests\unit\_OM\Domain;

use App\Domain\Shared\Enum\Role;

class RoleMother
{
    public static function create(Role $role): Role
    {
        return $role;
    }

    public static function createDefault(): Role
    {
        return self::create(
            Role::FREE_USER
        );
    }
}
