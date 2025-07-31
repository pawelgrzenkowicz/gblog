<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\SQL\Type\String;

use App\Domain\Shared\ValueObject\String\TitleVO;
use App\Infrastructure\Database\Doctrine\SQL\Type\String\RequestIPType;
use App\Infrastructure\Database\Doctrine\SQL\Type\String\TitleType;
use App\Infrastructure\Request\ValueObject\RequestIPVO;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RequestIPTypeTest extends TestCase
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
        $value = '127.0.0.1';

        // Then
        $this->assertEquals(
            $value,
            $this->createInstanceUnderTest()->convertToDatabaseValue(
                $this->createRequestIPValueObject($value), $this->abstractPlatform
            )
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $value = '127.0.0.1';

        // Then
        $this->assertEquals(
            $this->createRequestIPValueObject($value),
            $this->createInstanceUnderTest()->convertToPHPValue($value, $this->abstractPlatform)
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
        $this->assertSame('request_ip_type', $this->createInstanceUnderTest()->getName());
    }

    private function createInstanceUnderTest(): RequestIPType
    {
        return new RequestIPType();
    }

    private function createRequestIPValueObject(string $value): RequestIPVO
    {
        return new RequestIPVO($value);
    }
}
