<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\Object;

use App\Domain\Shared\ValueObject\Object\PictureVO;
use App\Infrastructure\Symfony\Error;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class PictureType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): ?array
    {
        if ($value !== null && !($value instanceof PictureVO)) {
            throw new UnprocessableEntityHttpException(Error::INVALID_DATA->value);
        }

        return [
            "source" => $value->source->value,
            "alt" => $value->alt->value,
            "extension" => $value->extension->value,
        ];
    }

    public function convertToPHPValue($value): ?PictureVO
    {
        if (null === $value) {
            return null;
        }

        if (!is_array($value)) {
            throw new UnprocessableEntityHttpException(Error::INVALID_DATA->value);
        }

        return new PictureVO($value["source"], $value["alt"], $value['extension']);
    }

    public static function getTypeName(): string
    {
        return "picture_type";
    }
}
