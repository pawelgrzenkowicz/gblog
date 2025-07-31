<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\ValueObject\String\SlugVO;
use App\Infrastructure\Database\Doctrine\Type\String\SlugType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class SlugTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(SlugType::getTypeName(), SlugType::class);
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
        $this->assertSame('slug_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): SlugType
    {
        return SlugType::getType(SlugType::getTypeName());
    }

    private function createValueObject(string $value): SlugVO
    {
        return new SlugVO($value);
    }
}
