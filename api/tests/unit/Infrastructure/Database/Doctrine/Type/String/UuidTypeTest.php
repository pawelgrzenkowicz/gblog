<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\String;

use App\Infrastructure\Database\Doctrine\Type\String\UuidType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UuidTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(UuidType::getTypeName(), UuidType::class);
    }

    public static function provideValueForConvertToDatabaseValue(): array
    {
        return [
            [
                'expected' => $uuid = Uuid::uuid4(),
                'value' => $uuid,
            ],
            [
                'expected' => $uuid = Uuid::uuid4()->toString(),
                'value' => $uuid,
            ],
            [
                'expected' => null,
                'value' => null,
            ],
        ];
    }

    #[DataProvider('provideValueForConvertToDatabaseValue')]
    public function testShouldConvertToDatabaseValue(mixed $expected, mixed $value): void
    {
        // Then
        $this->assertEquals(
            $expected,
            $this->createInstanceUnderTest()->convertToDatabaseValue($value)
        );
    }

    public static function provideValueForConvertToPHPValue(): array
    {
        return [
            [
                'expected' => $uuid = Uuid::uuid4(),
                'value' => $uuid->toString(),
            ],
            [
                'expected' => null,
                'value' => null,
            ],
        ];
    }

    #[DataProvider('provideValueForConvertToPHPValue')]
    public function testShouldConvertToPHPValue(mixed $expected, mixed $value): void
    {
        // Then
        $this->assertEquals(
            $expected,
            $this->createInstanceUnderTest()->convertToPHPValue($value)
        );
    }

    public function testShouldReturnValidTypeName(): void
    {
        $this->assertSame('uuid_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): UuidType
    {
        return UuidType::getType(UuidType::getTypeName());
    }
}
