<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\SQL\Type\Integer;

use App\Domain\Shared\ValueObject\Number\TestNumberVO;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class TestNumberType extends StringType
{
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): int
    {
        return $value->value;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): TestNumberVO
    {
        return new TestNumberVO((int) $value);
    }

    public function getName(): string
    {
        return 'test_number_type';
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 255;
        return parent::getSQLDeclaration($column, $platform);
    }
}
