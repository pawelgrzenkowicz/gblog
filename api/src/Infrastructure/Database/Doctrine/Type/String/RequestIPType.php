<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\String;

use App\Infrastructure\Request\ValueObject\RequestIPVO;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class RequestIPType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value): RequestIPVO
    {
        return new RequestIPVO($value);
    }

    public static function getTypeName(): string
    {
        return "request_ip_type";
    }
}
