<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\ValueObject\String\SlugVO;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class SlugType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value): SlugVO
    {
        return new SlugVO($value);
    }

    public static function getTypeName(): string
    {
        return "slug_type";
    }
}
