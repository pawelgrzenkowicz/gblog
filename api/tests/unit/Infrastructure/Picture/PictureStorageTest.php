<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Picture;

use App\Infrastructure\Filesystem\DirectoryInterface;
use App\Infrastructure\Picture\PictureStorage;
use App\Tests\unit\_OM\Domain\PictureMother;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

class PictureStorageTest extends TestCase
{
    private DirectoryInterface|MockObject $directory;

    protected function setUp(): void
    {
        $this->directory = $this->createMock(DirectoryInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->directory,
        );
    }

    public function testShouldGetPictureFile(): void
    {
        // Given
        $picture = PictureMother::createDefault();
        $file = new SplFileInfo($picture->source()->value);

        $this->directory
            ->expects($this->once())
            ->method('get')
            ->with($picture->source()->value)
            ->willReturn($file);

        // Then
        $this->assertEquals($file, $this->createInstanceUnderTest()->get($picture));
    }

    public function testShouldRemovePictureFile(): void
    {
        // Given
        $picture = PictureMother::createDefault();

        $this->directory
            ->expects($this->once())
            ->method('remove')
            ->with($picture->source()->value);

        // When
        $this->createInstanceUnderTest()->delete($picture);

        // Then
        $this->assertFalse($this->doesNotPerformAssertions());
    }

    public function testShouldPutPictureFile(): void
    {
        // Given
        $picture = PictureMother::createDefault();
        $file = $this->createMock(SplFileInfo::class);

        $file
            ->expects($this->once())
            ->method('isReadable')
            ->willReturn(true);

        $this->directory
            ->expects($this->once())
            ->method('put')
            ->with($picture->source()->value, $file);

        // When
        $this->createInstanceUnderTest()->put($picture, $file);

        // Then
        $this->assertFalse($this->doesNotPerformAssertions());
    }

    public function testShouldThrowExceptionWhenFileIsNotReadable(): void
    {
        // Given
        $picture = PictureMother::createDefault();
        $file = $this->createMock(SplFileInfo::class);

        $file
            ->expects($this->once())
            ->method('isReadable')
            ->willReturn(false);

        // Exception
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('PICTURE_IS_NOT_READABLE');

        // When
        $this->createInstanceUnderTest()->put($picture, $file);
    }

    public function createInstanceUnderTest(): PictureStorage
    {
        return new PictureStorage($this->directory);
    }
}
