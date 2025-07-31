<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\ValueObject\String\EmailVO;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class EmailType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): ?string
    {
        return $value->value;
    }

    public function convertToPHPValue($value): ?EmailVO
    {
        if (null === $value) {
            return null;
        }

        return new EmailVO($value);
    }

    public static function getTypeName(): string
    {
        return "email_type";
    }
}
