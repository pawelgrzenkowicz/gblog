<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\Object;

use App\Domain\Shared\Enum\PictureExtension;
use App\Domain\Shared\ValueObject\Object\PictureVO;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PictureVOTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $alt = uniqid();
        $source = uniqid();
        $extension = PictureExtension::JPG->value;

        // When
        $pictureVO = $this->createInstanceUnderTest($source, $alt, $extension);

        // Then
        $this->assertSame($alt, $pictureVO->alt->__toString());
        $this->assertSame($source, $pictureVO->source->__toString());
        $this->assertSame($extension, $pictureVO->extension->value);
    }

    public function testShouldReturnArrayFromObject(): void
    {
        // Given
        $alt = uniqid();
        $source = uniqid();
        $extension = PictureExtension::JPG->value;

        $expected = [
            'alt' => $alt,
            'extension' => $extension,
            'source' => $source,
        ];

        // When
        $pictureVO = $this->createInstanceUnderTest($source, $alt, $extension);

        // Then
        $this->assertSame($expected, $pictureVO->toArray());
    }

    public static function provideSources(): array
    {
        return [
            [
                'source' => sprintf('%s/%s.jpg', 'some/path/test', $pictureName = uniqid()),
                'pictureName' => $pictureName
            ],

            [
                'source' => sprintf('%s/%s.jpg', 'path/xd.adobe.com/view/123/screen', $pictureName = uniqid()),
                'pictureName' => $pictureName
            ],
        ];
    }

    #[DataProvider('provideSources')]
    public function testShouldReturnPictureNameFromSource(string $source, string $pictureName): void
    {
        // Given
        $alt = uniqid();
        $extension = PictureExtension::JPG->value;

        // When
        $pictureVO = $this->createInstanceUnderTest($source, $alt, $extension);

        // Then
        $this->assertSame($pictureName, $pictureVO->pictureName());
    }

    public function testShouldReturnPictureNameFromSourceIfSourceIsShort(): void
    {
        // Given
        $alt = uniqid();
        $source = sprintf('%s', $path = $pictureName = uniqid());
        $extension = PictureExtension::JPG->value;

        // When
        $pictureVO = $this->createInstanceUnderTest($source, $alt, $extension);

        // Then
        $this->assertSame($pictureName, $pictureVO->pictureName());
    }

    private function createInstanceUnderTest(string $source, string $alt, string $extension): PictureVO
    {
        return new PictureVO($source, $alt, $extension);
    }
}
