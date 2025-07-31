<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\SQL\Type\Object;

use App\Domain\Shared\Enum\PictureExtension;
use App\Domain\Shared\ValueObject\Object\PictureVO;
use App\Infrastructure\Database\Doctrine\SQL\Type\Object\PictureType;
use App\UI\Http\Rest\Error\ErrorType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class PictureTypeTest extends TestCase
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
        $extension = PictureExtension::JPG->value;

        // Then
        $this->assertEquals(
            ['source' => $source = uniqid(), 'alt' => $alt = uniqid(), 'extension' => $extension],
            $this->createInstanceUnderTest()->convertToDatabaseValue(
                $this->createPictureValueObject($source, $alt, $extension), $this->abstractPlatform
            )
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Given
        $extension = PictureExtension::JPG->value;

        // Then
        $this->assertEquals(
            $this->createPictureValueObject($source = uniqid(), $alt = uniqid(), $extension),
            $this->createInstanceUnderTest()->convertToPHPValue(
                ['source' => $source, 'alt' => $alt, 'extension' => $extension],
                $this->abstractPlatform
            )
        );
    }

    public function testShouldThrowExceptionWhenDataToSaveInDatabaseIsInvalid(): void
    {
        // Exception
        $this->expectException(UnprocessableEntityHttpException::class);
        $this->expectExceptionMessage(ErrorType::INVALID_DATA->value);

        // When
        $this->createInstanceUnderTest()->convertToDatabaseValue([null], $this->abstractPlatform);
    }

    public function testShouldReturnNullWhenNullIsInDatabase(): void
    {
        // Then
        $this->assertNull($this->createInstanceUnderTest()->convertToPHPValue(null, $this->abstractPlatform));
    }

    public function testShouldThrowExceptionWhenValueIsNotArray(): void
    {
        // Exception
        $this->expectException(UnprocessableEntityHttpException::class);
        $this->expectExceptionMessage(ErrorType::INVALID_DATA->value);

        // When
        $this->createInstanceUnderTest()->convertToPHPValue(uniqid(), $this->abstractPlatform);
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
        $this->assertSame('picture_type', $this->createInstanceUnderTest()->getName());
    }

    private function createInstanceUnderTest(): PictureType
    {
        return new PictureType();
    }

    private function createPictureValueObject(string $source, string $alt, string $extension): PictureVO
    {
        return new PictureVO($source, $alt, $extension);
    }
}
