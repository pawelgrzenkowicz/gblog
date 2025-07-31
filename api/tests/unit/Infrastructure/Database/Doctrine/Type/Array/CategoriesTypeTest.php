<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\Array;

use App\Domain\Shared\ValueObject\Iterable\CategoriesVO;
use App\Infrastructure\Database\Doctrine\Type\Array\CategoriesType;
use App\Infrastructure\Symfony\Error;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class CategoriesTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(CategoriesType::getTypeName(), CategoriesType::class);
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        // Given
        $values = [uniqid()];

        // Then
        $this->assertSame(
            $values,
            $this->createInstanceUnderTest()->convertToDatabaseValue($this->createValueObject($values))
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $values = [uniqid()];

        // Then
        $this->assertEquals(
            $this->createValueObject($values),
            $this->createInstanceUnderTest()->convertToPHPValue($values)
        );
    }

    public function testShouldReturnNullWhenNullIsInDatabase(): void
    {
        // Then
        $this->assertNull($this->createInstanceUnderTest()->convertToPHPValue(null));
    }

    public function testShouldThrowExceptionWhenDataToSaveInDatabaseIsInvalid(): void
    {
        // Exception
        $this->expectException(UnprocessableEntityHttpException::class);
        $this->expectExceptionMessage(Error::INVALID_DATA->value);

        // When
        $this->createInstanceUnderTest()->convertToDatabaseValue(uniqid());
    }

    public function testShouldThrowExceptionWhenDataFromDatabaseIsInvalid(): void
    {
        // Exception
        $this->expectException(UnprocessableEntityHttpException::class);
        $this->expectExceptionMessage(Error::INVALID_DATA->value);

        // When
        $this->createInstanceUnderTest()->convertToPHPValue(uniqid());
    }

    public function testShouldReturnValidTypeName()
    {
        $this->assertSame('categories_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): CategoriesType
    {
        return CategoriesType::getType(CategoriesType::getTypeName());
    }

    private function createValueObject(array $values): CategoriesVO
    {
        return new CategoriesVO($values);
    }
}
