<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\String;

use App\Infrastructure\Request\ValueObject\RequestRouteVO;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class RequestRouteType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value): RequestRouteVO
    {
        return new RequestRouteVO($value);
    }

    public static function getTypeName(): string
    {
        return "request_route_type";
    }
}
