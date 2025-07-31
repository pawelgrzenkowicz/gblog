<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\String;

use App\Infrastructure\Database\Doctrine\Type\String\RequestDateType;
use App\Infrastructure\Request\ValueObject\RequestDateVO;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class RequestDateTypeTest extends TestCase
{
    public const DEFAULT_DATETIME = '1994-06-30T17:40:00+00:00';

    protected function setUp(): void
    {
        Type::registerType(RequestDateType::getTypeName(), RequestDateType::class);
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        // Given
        $value = self::DEFAULT_DATETIME;

        // Then
        $this->assertSame(
            $value,
            $this->createInstanceUnderTest()->convertToDatabaseValue($this->createValueObject($value))
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $value = self::DEFAULT_DATETIME;

        // Then
        $this->assertEquals(
            $this->createValueObject($value),
            $this->createInstanceUnderTest()->convertToPHPValue($value)
        );
    }

    public function testShouldReturnValidTypeName()
    {
        $this->assertSame('request_date_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): RequestDateType
    {
        return RequestDateType::getType(RequestDateType::getTypeName());
    }

    private function createValueObject(string $value): RequestDateVO
    {
        return new RequestDateVO($value);
    }
}
