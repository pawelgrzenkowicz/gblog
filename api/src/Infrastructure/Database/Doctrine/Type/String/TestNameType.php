<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\ValueObject\String\NonEmptyVO;
use App\Domain\Shared\ValueObject\String\TestNameVO;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class TestNameType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value): TestNameVO
    {
        return new TestNameVO($value);
    }

    public static function getTypeName(): string
    {
        return "test_name_type";
    }
}
