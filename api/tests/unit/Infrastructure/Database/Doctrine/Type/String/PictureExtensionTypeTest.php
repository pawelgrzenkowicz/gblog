<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\String;


use App\Domain\Shared\Enum\PictureExtension;
use App\Infrastructure\Database\Doctrine\Type\String\PictureExtensionType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class PictureExtensionTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(PictureExtensionType::getTypeName(), PictureExtensionType::class);
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        // Then
        $this->assertSame(
            PictureExtension::JPG->value,
            $this->createInstanceUnderTest()->convertToDatabaseValue($this->createValueObject(PictureExtension::JPG->value))
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Then
        $this->assertEquals(
            PictureExtension::JPG,
            $this->createInstanceUnderTest()->convertToPHPValue(PictureExtension::JPG->value)
        );
    }

    public function testShouldReturnValidTypeName()
    {
        $this->assertSame('picture_extension_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): PictureExtensionType
    {
        return PictureExtensionType::getType(PictureExtensionType::getTypeName());
    }

    private function createValueObject(string $value): PictureExtension
    {
        return PictureExtension::from($value);
    }
}
