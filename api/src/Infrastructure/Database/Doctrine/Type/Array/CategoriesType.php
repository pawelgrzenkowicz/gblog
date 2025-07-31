<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\Array;

use App\Domain\Shared\ValueObject\Iterable\CategoriesVO;
use App\Infrastructure\Symfony\Error;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class CategoriesType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): ?array
    {
        if ($value !== null && !($value instanceof CategoriesVO)) {
            throw new UnprocessableEntityHttpException(Error::INVALID_DATA->value);
        }

        return $value->values;
    }

    public function convertToPHPValue($value): ?CategoriesVO
    {
        if (null === $value) {
            return null;
        }

        if (!is_array($value)) {
            throw new UnprocessableEntityHttpException(Error::INVALID_DATA->value);
        }

        return new CategoriesVO($value);
    }

    public static function getTypeName(): string
    {
        return "categories_type";
    }
}
