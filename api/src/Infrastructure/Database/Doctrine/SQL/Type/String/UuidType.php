<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\SQL\Type\String;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UuidType extends GuidType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (is_string($value)) {
            return $value;
        }

        return $value?->__toString();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?UuidInterface
    {
        if (null === $value) {
            return null;
        }

        return Uuid::fromString($value);
    }

    public function getName(): string
    {
        return "uuid_type";
    }
}
