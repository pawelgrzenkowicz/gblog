<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\String;

use App\Infrastructure\Request\ValueObject\RequestDateVO;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class RequestDateType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): string
    {
        return $value->value->toAtomString();
    }

    public function convertToPHPValue($value): RequestDateVO
    {
        return new RequestDateVO($value);
    }

    public static function getTypeName(): string
    {
        return "request_date_type";
    }
}
