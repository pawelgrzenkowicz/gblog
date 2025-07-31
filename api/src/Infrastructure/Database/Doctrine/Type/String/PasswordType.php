<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\ValueObject\String\PasswordVO;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class PasswordType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): ?string
    {
        return $value?->__toString();
    }

    public function convertToPHPValue($value): ?PasswordVO
    {
        if (null === $value) {
            return null;
        }

        return PasswordVO::fromString($value);
    }

    public static function getTypeName(): string
    {
        return "password_type";
    }
}
