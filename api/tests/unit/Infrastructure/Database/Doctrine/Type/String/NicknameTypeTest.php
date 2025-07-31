<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\ValueObject\String\NicknameVO;
use App\Infrastructure\Database\Doctrine\Type\String\NicknameType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class NicknameTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(NicknameType::getTypeName(), NicknameType::class);
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
        $this->assertSame('nickname_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): NicknameType
    {
        return NicknameType::getType(NicknameType::getTypeName());
    }

    private function createValueObject(string $value): NicknameVO
    {
        return new NicknameVO($value);
    }
}
