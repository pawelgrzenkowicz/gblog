<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\SQL\Type\String;

use App\Domain\Shared\Enum\PictureExtension;
use App\Infrastructure\Database\Doctrine\SQL\Type\String\PictureExtensionType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PictureExtensionTypeTest extends TestCase
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
        $value = PictureExtension::JPG->value;

        // Then
        $this->assertEquals(
            $value,
            $this->createInstanceUnderTest()->convertToDatabaseValue(
                $this->createPictureExtensionValueObject($value), $this->abstractPlatform
            )
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $value = PictureExtension::JPG;

        // Then
        $this->assertEquals(
            $value,
            $this->createInstanceUnderTest()->convertToPHPValue($value->value, $this->abstractPlatform)
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
        $this->assertSame('picture_extension_type', $this->createInstanceUnderTest()->getName());
    }

    private function createInstanceUnderTest(): PictureExtensionType
    {
        return new PictureExtensionType();
    }

    private function createPictureExtensionValueObject(string $value): PictureExtension
    {
        return PictureExtension::from($value);
    }
}
