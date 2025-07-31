<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\SQL\Type\String;

use App\Domain\Shared\ValueObject\String\PictureAltVO;
use App\Infrastructure\Database\Doctrine\SQL\Type\String\PictureAltType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PictureAltTypeTest extends TestCase
{
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
        $value = uniqid();

        // Then
        $this->assertEquals(
            $value,
            $this->createInstanceUnderTest()->convertToDatabaseValue(
                $this->createPictureAltValueObject($value), $this->abstractPlatform
            )
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $value = uniqid();

        // Then
        $this->assertEquals(
            $this->createPictureAltValueObject($value),
            $this->createInstanceUnderTest()->convertToPHPValue($value, $this->abstractPlatform)
        );
    }

    public function testShouldCheckSQLDeclaration(): void
    {
        // Given
        $this->abstractPlatform
            ->expects($this->once())
            ->method('getStringTypeDeclarationSQL')
            ->with(['length' => 255])
            ->willReturn($result = uniqid());

        // When
        $type = $this->createInstanceUnderTest()->getSQLDeclaration([], $this->abstractPlatform);

        // Then
        $this->assertEquals($type, $result);
    }

    public function testShouldReturnValidTypeName()
    {
        $this->assertSame('picture_alt_type', $this->createInstanceUnderTest()->getName());
    }

    private function createInstanceUnderTest(): PictureAltType
    {
        return new PictureAltType();
    }

    private function createPictureAltValueObject(string $value): PictureAltVO
    {
        return new PictureAltVO($value);
    }
}
