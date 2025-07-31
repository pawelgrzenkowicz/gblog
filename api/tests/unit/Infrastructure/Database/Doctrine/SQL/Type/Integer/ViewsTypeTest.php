<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\SQL\Type\Integer;

use App\Domain\Shared\ValueObject\Number\ViewsVO;
use App\Infrastructure\Database\Doctrine\SQL\Type\Integer\ViewsType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ViewsTypeTest extends TestCase
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
        $value = rand();

        // Then
        $this->assertEquals(
            $value,
            $this->createInstanceUnderTest()->convertToDatabaseValue(
                $this->createViewsValueObject($value), $this->abstractPlatform
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
            $this->createViewsValueObject($expected),
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
        $this->assertSame('views_type', $this->createInstanceUnderTest()->getName());
    }

    private function createInstanceUnderTest(): ViewsType
    {
        return new ViewsType();
    }

    private function createViewsValueObject(int $value): ViewsVO
    {
        return new ViewsVO($value);
    }
}
