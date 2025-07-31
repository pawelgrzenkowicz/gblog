<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\ValueObject\Date\PublicationDateVO;
use App\Infrastructure\Database\Doctrine\Type\String\PublicationDateType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class PublicationDateTypeTest extends TestCase
{
    public const string DEFAULT_DATETIME = '1994-06-30T17:40:00+00:00';

    protected function setUp(): void
    {
        Type::registerType(PublicationDateType::getTypeName(), PublicationDateType::class);
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        // Given
        $value = self::DEFAULT_DATETIME;

        // Then
        $this->assertSame(
            $value,
            $this->createInstanceUnderTest()->convertToDatabaseValue($this->createValueObject($value))
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $value = self::DEFAULT_DATETIME;

        // Then
        $this->assertEquals(
            $this->createValueObject($value),
            $this->createInstanceUnderTest()->convertToPHPValue($value)
        );
    }

    public function testShouldReturnValidTypeName()
    {
        $this->assertSame('publication_date_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): PublicationDateType
    {
        return PublicationDateType::getType(PublicationDateType::getTypeName());
    }

    private function createValueObject(string $value): PublicationDateVO
    {
        return new PublicationDateVO($value);
    }
}
