<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\Enum\PictureExtension;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class PictureExtensionType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value): PictureExtension
    {
        return PictureExtension::from($value);
    }

    public static function getTypeName(): string
    {
        return "picture_extension_type";
    }
}
