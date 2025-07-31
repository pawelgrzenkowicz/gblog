<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Picture\Command;

use App\Application\Picture\Command\AddPicture;
use App\Domain\Shared\Enum\PictureExtension;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

class AddPictureTest extends TestCase
{
    public static function providePictures(): array
    {
        $name1 = 'dragon-ball-db.jpg';
        $name2 = 'dragon-ball-db2.jpg';

        return [
            [
                'source' => $name1,
                'file' => new SplFileInfo(__DIR__ . sprintf('/../../../../public/core/%s', $name1)),
                'alt' => uniqid(),
                'extension' => PictureExtension::JPG,
            ],
            [
                'source' => $name2,
                'file' => new SplFileInfo(__DIR__ . sprintf('/../../../../public/core/%s', $name2)),
                'alt' => uniqid(),
                'extension' => PictureExtension::PNG,
            ],
        ];
    }

    #[DataProvider('providePictures')]
    public function testShouldCreateValidObject(
        string $source,
        SplFileInfo $file,
        string $alt,
        PictureExtension $extension
    ): void {
        // When
        $actual = new AddPicture($source, $alt, $extension->value, $file);

        // Then
        $this->assertEquals($source, $actual->picture->source);
        $this->assertEquals($alt, $actual->picture->alt);
        $this->assertEquals($extension, $actual->picture->extension);
        $this->assertEquals($file, $actual->file);
    }
}
