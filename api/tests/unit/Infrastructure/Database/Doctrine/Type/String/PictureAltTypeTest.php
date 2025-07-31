<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\ValueObject\String\PictureAltVO;
use App\Infrastructure\Database\Doctrine\Type\String\PictureAltType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class PictureAltTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(PictureAltType::getTypeName(), PictureAltType::class);
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        // Given
        $value = uniqid();

        // Then
        $this->assertSame(
            $value,
            $this->createInstanceUnderTest()->convertToDatabaseValue($this->createValueObject($value))
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $value = uniqid();

        // Then
        $this->assertEquals(
            $this->createValueObject($value),
            $this->createInstanceUnderTest()->convertToPHPValue($value)
        );
    }

    public function testShouldReturnValidTypeName()
    {
        $this->assertSame('picture_alt_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): PictureAltType
    {
        return PictureAltType::getType(PictureAltType::getTypeName());
    }

    private function createValueObject(string $value): PictureAltVO
    {
        return new PictureAltVO($value);
    }
}
