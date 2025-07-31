<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Filesystem;

use App\Infrastructure\Filesystem\Directory;
use Codeception\PHPUnit\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use SplFileInfo;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

class DirectoryTest extends TestCase
{
    private const CORE_FILES_DIRECTORY = __DIR__ . '/../../../../public/core/';
    private const EXIST_FILE_NAME = 'dragon-ball-db.jpg';

    private Filesystem|MockObject $filesystem;

    protected function setUp(): void
    {
        $this->filesystem = $this->createMock(Filesystem::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->filesystem,
        );
    }

    public function testShouldCreateValidObject(): void
    {
        // Given
        $this->filesystem
            ->expects($this->once())
            ->method('mkdir')
            ->with(self::CORE_FILES_DIRECTORY);

        // When
        $this->createInstanceUnderTest();

        // Then
        $this->assertFalse($this->doesNotPerformAssertions());
    }

    public function testShouldReturnNullWhenTryToGetNotExistFile(): void
    {
        // Then
        $this->assertNull($this->createInstanceUnderTest()->get(uniqid()));
    }

    public function testShouldReturnFileWhenGet(): void
    {
        // Given
        $filename = self::EXIST_FILE_NAME;
        $file = new SplFileInfo(self::CORE_FILES_DIRECTORY . '/' . $filename);

        // When
        $actual = $this->createInstanceUnderTest()->get($filename);

        // Then
        $this->assertEquals($file, $actual);
    }

    public function testShouldCreateFileLink(): void
    {
        // Given
        $file = new SplFileInfo(self::CORE_FILES_DIRECTORY . '/' . self::EXIST_FILE_NAME);
        $path = $file->getPathname();

        $this->filesystem
            ->expects($this->once())
            ->method('symlink')
            ->with($path, Path::makeAbsolute($path, self::CORE_FILES_DIRECTORY));

        // When
        $this->createInstanceUnderTest()->link($path, $file);

        // Then
        $this->assertFalse($this->doesNotPerformAssertions());
    }

    public function testShouldCreateFileCopy(): void
    {
        // Given
        $file = new SplFileInfo(self::CORE_FILES_DIRECTORY . '/' . self::EXIST_FILE_NAME);
        $path = $file->getPathname();

        $this->filesystem
            ->expects($this->once())
            ->method('copy')
            ->with($path, Path::makeAbsolute($path, self::CORE_FILES_DIRECTORY));

        // When
        $this->createInstanceUnderTest()->put($path, $file);

        // Then
        $this->assertFalse($this->doesNotPerformAssertions());
    }

    public function testShouldRemoveFile(): void
    {
        // Given
        $file = new SplFileInfo(self::CORE_FILES_DIRECTORY . '/' . self::EXIST_FILE_NAME);
        $path = $file->getPathname();

        $this->filesystem
            ->expects($this->once())
            ->method('remove')
            ->with(Path::makeAbsolute($path, self::CORE_FILES_DIRECTORY));

        // When
        $this->createInstanceUnderTest()->remove($path);

        // Then
        $this->assertFalse($this->doesNotPerformAssertions());
    }

    private function createInstanceUnderTest(): Directory
    {
        return new Directory($this->filesystem, self::CORE_FILES_DIRECTORY);
    }
}
