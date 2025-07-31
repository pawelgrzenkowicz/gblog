<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\String;

use App\Infrastructure\Database\Doctrine\Type\String\RequestRouteType;
use App\Infrastructure\Request\ValueObject\RequestRouteVO;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class RequestRouteTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(RequestRouteType::getTypeName(), RequestRouteType::class);
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
        $this->assertSame('request_route_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): RequestRouteType
    {
        return RequestRouteType::getType(RequestRouteType::getTypeName());
    }

    private function createValueObject(string $value): RequestRouteVO
    {
        return new RequestRouteVO($value);
    }
}
