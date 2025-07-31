<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\ValueObject\String\TestNameVO;
use App\Infrastructure\Database\Doctrine\Type\String\TestNameType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class TestTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(TestNameType::getTypeName(), TestNameType::class);
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
        $this->assertSame('test_name_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): TestNameType
    {
        return TestNameType::getType(TestNameType::getTypeName());
    }

    private function createValueObject(string $value): TestNameVO
    {
        return new TestNameVO($value);
    }
}
