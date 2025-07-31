<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\SQL\Type\String;

use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Infrastructure\Database\Doctrine\SQL\Type\String\EmailType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class EmailTypeTest extends TestCase
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
        $email = sprintf('%s@gmail.com', uniqid());

        // Then
        $this->assertEquals(
            $email,
            $this->createInstanceUnderTest()->convertToDatabaseValue(
                $this->createEmailValueObject($email), $this->abstractPlatform
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
        $email = sprintf('%s@gmail.com', uniqid());

        // Then
        $this->assertEquals(
            $this->createEmailValueObject($email),
            $this->createInstanceUnderTest()->convertToPHPValue($email, $this->abstractPlatform)
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
        $this->assertSame('email_type', $this->createInstanceUnderTest()->getName());
    }

    private function createInstanceUnderTest(): EmailType
    {
        return new EmailType();
    }

    private function createEmailValueObject(string $value): EmailVO
    {
        return new EmailVO($value);
    }
}
