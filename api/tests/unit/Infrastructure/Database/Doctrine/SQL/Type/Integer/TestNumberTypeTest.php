<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\SQL\Type\Integer;

use App\Domain\Shared\ValueObject\Number\TestNumberVO;
use App\Infrastructure\Database\Doctrine\SQL\Type\Integer\TestNumberType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TestNumberTypeTest extends TestCase
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
        $value = random_int(1, 100);

        // Then
        $this->assertEquals(
            $value,
            $this->createInstanceUnderTest()->convertToDatabaseValue(
                $this->createTestNumberValueObject($value), $this->abstractPlatform
            )
        );
    }

    public static function provideValuesToConvertToPHP(): array
    {
        return [
            [
                'value' => $value = random_int(1, 100),
                'expected' => $value
            ],
            [
                'value' => (string) $value = random_int(1, 100),
                'expected' => $value
            ],
        ];
    }

    #[DataProvider('provideValuesToConvertToPHP')]
    public function testShouldConvertToPHPValue(int|string $value, int $expected): void
    {
        // Then
        $this->assertEquals(
            $this->createTestNumberValueObject($expected),
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
        $this->assertSame('test_number_type', $this->createInstanceUnderTest()->getName());
    }

    private function createInstanceUnderTest(): TestNumberType
    {
        return new TestNumberType();
    }

    private function createTestNumberValueObject(int $value): TestNumberVO
    {
        return new TestNumberVO($value);
    }
}
