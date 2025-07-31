<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\Integer;

use App\Domain\Shared\ValueObject\Number\NaturalNumberVO;
use App\Infrastructure\Database\Doctrine\Type\Integer\NaturalNumberType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class NaturalNumberTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(NaturalNumberType::getTypeName(), NaturalNumberType::class);
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
        $this->assertSame('natural_number_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): NaturalNumberType
    {
        return NaturalNumberType::getType(NaturalNumberType::getTypeName());
    }

    private function createNonNegative(int $value): NaturalNumberVO
    {
        return new NaturalNumberVO($value);
    }
}
