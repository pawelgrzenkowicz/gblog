<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\Integer;

use App\Domain\Shared\ValueObject\Number\NaturalNumberVO;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class NaturalNumberType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): int
    {
        return $value->value;
    }

    public function convertToPHPValue($value): NaturalNumberVO
    {
        return new NaturalNumberVO($value);
    }

    public static function getTypeName(): string
    {
        return "natural_number_type";
    }
}
