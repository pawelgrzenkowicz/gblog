<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\SQL\Type\String;

use App\Infrastructure\Database\Doctrine\SQL\Type\String\UuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UuidTypeTest extends TestCase
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
            $this->createInstanceUnderTest()->convertToDatabaseValue($value, $this->abstractPlatform)
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
            $this->createInstanceUnderTest()->convertToPHPValue($value, $this->abstractPlatform)
        );
    }

    public function testShouldReturnValidTypeName()
    {
        $this->assertSame('uuid_type', $this->createInstanceUnderTest()->getName());
    }

    private function createInstanceUnderTest(): UuidType
    {
        return new UuidType();
    }
}
