<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\SQL\Type\Date;

use App\Domain\Shared\ValueObject\Date\PublicationDateVO;
use App\Infrastructure\Database\Doctrine\SQL\Type\Date\PublicationDateType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PublicationDateTypeTest extends TestCase
{
    private const string DEFAULT_DATETIME = '1994-06-30T17:40:00+00:00';

    private AbstractPlatform|MockObject $abstractPlatform;

    protected function setUp(): void
    {
        $this->abstractPlatform = $this->createMock(AbstractPlatform::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->abstractPlatform
        );
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        // Given
        $value = self::DEFAULT_DATETIME;
        $this->abstractPlatform
            ->expects($this->once())
            ->method('getDateTimeFormatString')
            ->willReturn('Y-m-d H:i:s');

        // Then
        $this->assertEquals(
            '1994-06-30 17:40:00',
            $this->createInstanceUnderTest()->convertToDatabaseValue(
                $this->createPublicationDateValueObject($value)->value, $this->abstractPlatform
            )
        );
    }

    public function testShouldConvertToDatabaseNull(): void
    {
        // Given
        $value = null;

        // Then
        $this->assertEquals(
            $value,
            $this->createInstanceUnderTest()->convertToDatabaseValue(
                $value, $this->abstractPlatform
            )
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $value = self::DEFAULT_DATETIME;

        // Then
        $this->assertEquals(
            $this->createPublicationDateValueObject($value)->value,
            $this->createInstanceUnderTest()->convertToPHPValue($value, $this->abstractPlatform)
        );
    }

    public function testShouldConvertToPHPNull(): void
    {
        // Given
        $value = null;

        // Then
        $this->assertEquals(
            $value,
            $this->createInstanceUnderTest()->convertToPHPValue($value, $this->abstractPlatform)
        );
    }

    public function testShouldCheckSQLDeclaration(): void
    {
        // Given
        $this->abstractPlatform
            ->expects($this->once())
            ->method('getDateTimeTzTypeDeclarationSQL')
            ->with(['length' => 255])
            ->willReturn($result = uniqid());

        // When
        $type = $this->createInstanceUnderTest()->getSQLDeclaration([], $this->abstractPlatform);

        // Then
        $this->assertEquals($type, $result);
    }

    public function testShouldReturnValidTypeName()
    {
        $this->assertSame('publication_date_type', $this->createInstanceUnderTest()->getName());
    }

    private function createInstanceUnderTest(): PublicationDateType
    {
        return new PublicationDateType();
    }

    private function createPublicationDateValueObject(string $date): PublicationDateVO
    {
        return new PublicationDateVO($date);
    }
}
