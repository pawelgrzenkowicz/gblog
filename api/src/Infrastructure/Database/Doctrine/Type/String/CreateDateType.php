<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\ValueObject\Date\CreateDateVO;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class CreateDateType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): string
    {
        return $value->value->toAtomString();
    }

    public function convertToPHPValue($value): CreateDateVO
    {
//        return new CreateDateVO($value->toDateTime()->format(DATE_ATOM));
        return new CreateDateVO($value);
    }

    public static function getTypeName(): string
    {
        return "create_date_type";
    }
}
