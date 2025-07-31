<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\ValueObject\String\TitleVO;
use App\Infrastructure\Database\Doctrine\Type\String\TitleType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class TitleTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(TitleType::getTypeName(), TitleType::class);
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
        $this->assertSame('title_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): TitleType
    {
        return TitleType::getType(TitleType::getTypeName());
    }

    private function createValueObject(string $value): TitleVO
    {
        return new TitleVO($value);
    }
}
