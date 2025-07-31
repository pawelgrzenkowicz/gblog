<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Picture\Command;

use App\Application\Picture\Command\EditPicture;
use App\Domain\Shared\Enum\PictureExtension;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

class EditPictureTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $source = 'dragon-ball-db2.jpg';
        $file = new SplFileInfo(__DIR__ . sprintf('/../../../../public/core/%s', $source));
        $alt = uniqid();
        $extension = PictureExtension::PNG;

        // Exception

        // When
        $command = $this->createInstanceUnderTest($source, $alt, $extension->value, $file);

        // Then
        $this->assertSame($source, $command->picture->source->__toString());
        $this->assertSame($alt, $command->picture->alt->__toString());
        $this->assertSame($extension, $command->picture->extension);
        $this->assertSame($file, $command->file);
    }

    private function createInstanceUnderTest(
        string $source,
        string $alt,
        string $extension,
        SplFileInfo $file
    ): EditPicture {
        return new EditPicture($source, $alt, $extension, $file);
    }
}
