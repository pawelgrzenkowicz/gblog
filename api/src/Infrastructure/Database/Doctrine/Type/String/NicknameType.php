<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\ValueObject\String\NicknameVO;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class NicknameType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value): NicknameVO
    {
        return new NicknameVO($value);
    }

    public static function getTypeName(): string
    {
        return "nickname_type";
    }
}
