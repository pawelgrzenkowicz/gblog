<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\String;

use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UuidType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): ?string
    {
        if (is_string($value)) {
            return $value;
        }

        return $value?->__toString();
    }

    public function convertToPHPValue($value): ?UuidInterface
    {
        if (null === $value) {
            return null;
        }

        return Uuid::fromString($value);
    }

    public static function getTypeName(): string
    {
        return "uuid_type";
    }
}
