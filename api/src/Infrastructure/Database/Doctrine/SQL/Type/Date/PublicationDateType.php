<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\SQL\Type\Date;

use App\Domain\Shared\ValueObject\Date\PublicationDateVO;
use Carbon\Carbon;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeTzType;

class PublicationDateType extends DateTimeTzType
{
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        return $value?->format($platform->getDateTimeFormatString());
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Carbon
    {
        return $value ? (new PublicationDateVO($value))->value : null;
    }

    public function getName(): string
    {
        return 'publication_date_type';
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 255;
        return parent::getSQLDeclaration($column, $platform);
    }
}
