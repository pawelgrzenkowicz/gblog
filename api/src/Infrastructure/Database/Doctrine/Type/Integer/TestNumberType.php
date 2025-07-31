<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\Integer;

use App\Domain\Shared\ValueObject\Number\TestNumberVO;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class TestNumberType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): int
    {
        return $value->value;
    }

    public function convertToPHPValue($value): TestNumberVO
    {
        return new TestNumberVO($value);
    }

    public static function getTypeName(): string
    {
        return "test_number_type";
    }
}
