<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\Integer;

use App\Domain\Shared\ValueObject\Number\TestNumberVO;
use App\Infrastructure\Database\Doctrine\Type\Integer\TestNumberType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class TestNumberTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(TestNumberType::getTypeName(), TestNumberType::class);
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        // Given
        $value = rand(1, 100);

        // Then
        $this->assertSame(
            $value,
            $this->createInstanceUnderTest()->convertToDatabaseValue($this->createTestNumberVO($value))
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $value = rand(1, 100);

        // Then
        $this->assertEquals(
            $this->createTestNumberVO($value),
            $this->createInstanceUnderTest()->convertToPHPValue($value)
        );
    }

    public function testShouldReturnValidTypeName()
    {
        $this->assertSame('test_number_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): TestNumberType
    {
        return TestNumberType::getType(TestNumberType::getTypeName());
    }

    private function createTestNumberVO(int $value): TestNumberVO
    {
        return new TestNumberVO($value);
    }
}
