<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\SQL\Type\Date;

use App\Domain\Shared\ValueObject\Date\CreateDateVO;
use Carbon\Carbon;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeTzType;

class CreateDateType extends DateTimeTzType
{
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string
    {
        return $value->format($platform->getDateTimeFormatString());
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Carbon
    {
        return (new CreateDateVO($value))->value;
    }

    public function getName(): string
    {
        return 'create_date_type';
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 255;
        return parent::getSQLDeclaration($column, $platform);
    }
}
