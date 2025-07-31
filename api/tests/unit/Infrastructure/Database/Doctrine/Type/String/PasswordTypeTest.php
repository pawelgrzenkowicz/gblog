<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\ValueObject\String\PasswordVO;
use App\Infrastructure\Database\Doctrine\Type\String\PasswordType;
use App\Tests\unit\_OM\Domain\Shared\ValueObject\String\PasswordVOMother;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class PasswordTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(PasswordType::getTypeName(), PasswordType::class);
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        // Given
        $password = 'CosCos1!';

        // Then
        $this->assertSame(
            $password,
            $this->createInstanceUnderTest()->convertToDatabaseValue($this->createPasswordVO($password))
        );
    }

    public function testShouldConvertToDatabaseValueAndReturnNull(): void
    {
        // Then
        $this->assertSame(
            null,
            $this->createInstanceUnderTest()->convertToDatabaseValue(null)
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $password = PasswordVOMother::random();

        // Then
        $this->assertEquals(
            $password,
            $this->createInstanceUnderTest()->convertToPHPValue((string)$password)
        );
    }

    public function testShouldConvertToPHPValueAndReturnNull(): void
    {
        // Then
        $this->assertEquals(
            null,
            $this->createInstanceUnderTest()->convertToPHPValue(null)
        );
    }

    public function testShouldReturnValidTypeName(): void
    {
        $this->assertSame('password_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): PasswordType
    {
        return PasswordType::getType(PasswordType::getTypeName());
    }

    private function createPasswordVO(?string $password): PasswordVO
    {
        return PasswordVOMother::exactly($password);
    }
}
