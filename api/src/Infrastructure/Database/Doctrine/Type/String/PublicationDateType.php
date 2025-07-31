<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\ValueObject\Date\PublicationDateVO;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class PublicationDateType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): ?string
    {
        return $value ? $value->value->toAtomString() : null;
    }

    public function convertToPHPValue($value): ?PublicationDateVO
    {
        return $value ? new PublicationDateVO($value) : null;
    }

    public static function getTypeName(): string
    {
        return "publication_date_type";
    }
}
