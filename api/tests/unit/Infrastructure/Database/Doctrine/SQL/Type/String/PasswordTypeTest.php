<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\SQL\Type\String;

use App\Domain\Shared\ValueObject\String\PasswordVO;
use App\Infrastructure\Database\Doctrine\SQL\Type\String\PasswordType;
use App\Tests\unit\_OM\Domain\Shared\ValueObject\String\PasswordVOMother;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PasswordTypeTest extends TestCase
{
    private AbstractPlatform|MockObject $abstractPlatform;

    protected function setUp(): void
    {
        $this->abstractPlatform = $this->createMock(AbstractPlatform::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->abstractPlatform
        );
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        // Given
        $password = 'CosCos1!';

        // Then
        $this->assertEquals(
            $password,
            $this->createInstanceUnderTest()->convertToDatabaseValue(
                $this->createPasswordValueObject($password), $this->abstractPlatform
            )
        );
    }

    public function testShouldConvertToDatabaseValueAndReturnNull(): void
    {
        // Then
        $this->assertSame(
            null,
            $this->createInstanceUnderTest()->convertToDatabaseValue(null, $this->abstractPlatform)
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $password = PasswordVOMother::random();

        // Then
        $this->assertEquals(
            $password,
            $this->createInstanceUnderTest()->convertToPHPValue((string) $password, $this->abstractPlatform)
        );
    }

    public function testShouldConvertToPHPValueAndReturnNull(): void
    {
        // Then
        $this->assertEquals(
            null,
            $this->createInstanceUnderTest()->convertToPHPValue(null, $this->abstractPlatform)
        );
    }

    public function testShouldCheckSQLDeclaration(): void
    {
        // Given
        $this->abstractPlatform
            ->expects($this->once())
            ->method('getStringTypeDeclarationSQL')
            ->with(['length' => 255])
            ->willReturn($result = uniqid());

        // When
        $type = $this->createInstanceUnderTest()->getSQLDeclaration([], $this->abstractPlatform);

        // Then
        $this->assertEquals($type, $result);
    }

    public function testShouldReturnValidTypeName()
    {
        $this->assertSame('password_type', $this->createInstanceUnderTest()->getName());
    }

    private function createInstanceUnderTest(): PasswordType
    {
        return new PasswordType();
    }

    private function createPasswordValueObject(string $value): PasswordVO
    {
        return PasswordVOMother::exactly($value);
    }
}
