<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\SQL\Type\String;

use App\Domain\Shared\Enum\Role;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class RoleType extends StringType
{
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): Role
    {
        return Role::from($value);
    }

    public function getName(): string
    {
        return 'role_type';
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 255;
        return parent::getSQLDeclaration($column, $platform);
    }
}
