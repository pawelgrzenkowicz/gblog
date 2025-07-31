<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\Integer;

use App\Domain\Shared\ValueObject\Number\ViewsVO;
use App\Infrastructure\Database\Doctrine\Type\Integer\ViewsType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class ViewsTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(ViewsType::getTypeName(), ViewsType::class);
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
        $this->assertSame('views_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): ViewsType
    {
        return ViewsType::getType(ViewsType::getTypeName());
    }

    private function createNonNegative(int $value): ViewsVO
    {
        return new ViewsVO($value);
    }
}
