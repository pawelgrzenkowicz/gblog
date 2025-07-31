<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\Enum\Role;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class RoleType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value): Role
    {
        return Role::from($value);
    }

    public static function getTypeName(): string
    {
        return "role_type";
    }
}
