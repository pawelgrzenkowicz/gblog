<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\SQL\Type\Object;

use App\Domain\Shared\ValueObject\Object\PictureVO;
use App\Infrastructure\Symfony\Error;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class PictureType extends Type
{
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): array
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

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?PictureVO
    {
        if (null === $value) {
            return null;
        }

        if (!is_array($value)) {
            throw new UnprocessableEntityHttpException(Error::INVALID_DATA->value);
        }

        return new PictureVO($value["source"], $value["alt"], $value['extension']);
    }

    public function getName(): string
    {
        return 'picture_type';
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 255;
        return $platform->getStringTypeDeclarationSQL($column);
    }
}
