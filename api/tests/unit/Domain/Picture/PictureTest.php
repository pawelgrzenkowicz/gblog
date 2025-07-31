<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Picture;

use App\Domain\Picture\Picture;
use App\Domain\Shared\Enum\PictureExtension;
use App\Domain\Shared\ValueObject\String\PictureAltVO;
use App\Domain\Shared\ValueObject\String\PictureSourceVO;
use App\Tests\unit\_OM\Domain\PictureMother;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class PictureTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $uuid = Uuid::uuid4();
        $alt = uniqid();
        $extension = PictureExtension::JPG;
        $source = uniqid();

        // When
        $pictureClass = $this->createInstanceUnderTest($uuid->toString(), $alt, $extension, $source);

        // Then
        $this->assertInstanceOf(UuidInterface::class, $pictureClass->uuid);
        $this->assertEquals($uuid, $pictureClass->uuid);
        $this->assertSame($alt, $pictureClass->alt()->__toString());
        $this->assertSame($source, $pictureClass->source()->__toString());
        $this->assertSame($extension, $pictureClass->extension());
        $this->assertSame(
            ['alt' => $alt, 'extension' => $extension->value, 'source' => $source],
            $pictureClass->toArray()
        );
    }

    public static function providePictureSource(): array
    {
        return [
            [
                'alt' => uniqid(),
                'extension' => PictureExtension::JPG,
                'pictureSource' => 'some/url/name-test.jpg',
                'expected' => 'name-test',
            ],
            [
                'alt' => uniqid(),
                'extension' => PictureExtension::JPG,
                'pictureSource' => 'name-test.jpg',
                'expected' => 'name-test.jpg',
            ],
        ];
    }

    #[DataProvider('providePictureSource')]
    public function testShouldReturnValidFormattedPictureName(
        string $alt,
        PictureExtension $extension,
        string $pictureSource,
        string $expected
    ): void {
        // When
        $pictureClass = $this->createInstanceUnderTest(Uuid::uuid4()->toString(), $alt, $extension, $pictureSource);

        // Then
        $this->assertSame($expected, $pictureClass->pictureNameFormatter(new PictureSourceVO($pictureSource)));
    }

    private function createInstanceUnderTest(
        string $uuid,
        string $alt,
        PictureExtension $extension,
        string $source
    ): Picture {
        return PictureMother::create(
            Uuid::fromString($uuid),
            new PictureAltVO($alt),
            $extension,
            new PictureSourceVO($source)
        );
    }
}
