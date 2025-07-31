<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\Integer;

use App\Domain\Shared\ValueObject\Number\NonNegativeVO;
use App\Infrastructure\Database\Doctrine\Type\Integer\NonNegativeType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class NonNegativeTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(NonNegativeType::getTypeName(), NonNegativeType::class);
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        // Given
        $value = rand();

        // Then
        $this->assertEquals(
            $value,
            $this->createInstanceUnderTest()->convertToDatabaseValue($this->createNonNegative($value))
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $value = rand();

        // Then
        $this->assertEquals(
            $this->createNonNegative($value),
            $this->createInstanceUnderTest()->convertToPHPValue($value)
        );
    }

    public function testShouldReturnValidTypeName()
    {
        $this->assertSame('non_negative_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): NonNegativeType
    {
        return NonNegativeType::getType(NonNegativeType::getTypeName());
    }

    private function createNonNegative(int $value): NonNegativeVO
    {
        return new NonNegativeVO($value);
    }
}
