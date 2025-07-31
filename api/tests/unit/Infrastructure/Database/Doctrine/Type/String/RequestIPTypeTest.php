<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\String;

use App\Infrastructure\Database\Doctrine\Type\String\RequestIPType;
use App\Infrastructure\Request\ValueObject\RequestIPVO;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class RequestIPTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(RequestIPType::getTypeName(), RequestIPType::class);
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        // Given
        $value = '127.0.0.1';

        // Then
        $this->assertSame(
            $value,
            $this->createInstanceUnderTest()->convertToDatabaseValue($this->createValueObject($value))
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $value = '127.0.0.1';

        // Then
        $this->assertEquals(
            $this->createValueObject($value),
            $this->createInstanceUnderTest()->convertToPHPValue($value)
        );
    }

    public function testShouldReturnValidTypeName()
    {
        $this->assertSame('request_ip_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): RequestIPType
    {
        return RequestIPType::getType(RequestIPType::getTypeName());
    }

    private function createValueObject(string $value): RequestIPVO
    {
        return new RequestIPVO($value);
    }
}
