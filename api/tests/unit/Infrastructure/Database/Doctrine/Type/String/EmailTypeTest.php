<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Infrastructure\Database\Doctrine\Type\String\EmailType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class EmailTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(EmailType::getTypeName(), EmailType::class);
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        // Given
        $email = sprintf('%s@gmail.com', uniqid());

        // Then
        $this->assertSame(
            $email,
            $this->createInstanceUnderTest()->convertToDatabaseValue($this->createEmailVO($email))
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $email = sprintf('%s@gmail.com', uniqid());

        // Then
        $this->assertEquals(
            $this->createEmailVO($email),
            $this->createInstanceUnderTest()->convertToPHPValue($email)
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
        $this->assertSame('email_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): EmailType
    {
        return EmailType::getType(EmailType::getTypeName());
    }

    private function createEmailVO(string $email): EmailVO
    {
        return new EmailVO($email);
    }
}
