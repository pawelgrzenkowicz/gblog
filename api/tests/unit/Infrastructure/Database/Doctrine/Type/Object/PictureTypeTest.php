<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\Object;

use App\Domain\Shared\Enum\PictureExtension;
use App\Domain\Shared\ValueObject\Object\PictureVO;
use App\Infrastructure\Database\Doctrine\Type\Object\PictureType;
use App\UI\Http\Rest\Error\ErrorType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class PictureTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(PictureType::getTypeName(), PictureType::class);
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        // Given
        $extension = PictureExtension::JPG->value;

        // Then
        $this->assertSame(
            ['source' => $source = uniqid(), 'alt' => $alt = uniqid(), 'extension' => $extension],
            $this->createInstanceUnderTest()->convertToDatabaseValue($this->createPictureVO($source, $alt, $extension))
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $extension = PictureExtension::JPG->value;

        // Then
        $this->assertEquals(
            $this->createPictureVO($source = uniqid(), $alt = uniqid(), $extension),
            $this->createInstanceUnderTest()->convertToPHPValue(['source' => $source, 'alt' => $alt, 'extension' => $extension])
        );
    }

    public function testShouldThrowExceptionWhenDataToSaveInDatabaseIsInvalid(): void
    {
        // Exception
        $this->expectException(UnprocessableEntityHttpException::class);
        $this->expectExceptionMessage(ErrorType::INVALID_DATA->value);

        // When
        $this->createInstanceUnderTest()->convertToDatabaseValue([null]);
    }

    public function testShouldReturnNullWhenNullIsInDatabase(): void
    {
        // Then
        $this->assertNull($this->createInstanceUnderTest()->convertToPHPValue(null));
    }

    public function testShouldThrowExceptionWhenValueIsNotArray(): void
    {
        // Exception
        $this->expectException(UnprocessableEntityHttpException::class);
        $this->expectExceptionMessage(ErrorType::INVALID_DATA->value);

        // When
        $this->createInstanceUnderTest()->convertToPHPValue(uniqid());
    }

    public function testShouldReturnValidTypeName()
    {
        $this->assertSame('picture_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): PictureType
    {
        return PictureType::getType(PictureType::getTypeName());
    }

    private function createPictureVO(string $source, string $alt, string $extension): PictureVO
    {
        return new PictureVO($source, $alt, $extension);
    }
}
