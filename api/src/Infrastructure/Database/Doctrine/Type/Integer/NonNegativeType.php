<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\Integer;

use App\Domain\Shared\ValueObject\Number\NonNegativeVO;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class NonNegativeType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): int
    {
        return $value->value;
    }

    public function convertToPHPValue($value): NonNegativeVO
    {
        return new NonNegativeVO($value);
    }

    public static function getTypeName(): string
    {
        return "non_negative_type";
    }
}
