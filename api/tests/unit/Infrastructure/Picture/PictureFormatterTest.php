<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Picture;

use App\Domain\Picture\PictureFileStorage;
use App\Infrastructure\Filesystem\DirectoryInterface;
use App\Infrastructure\Picture\Dimensions;
use App\Infrastructure\Picture\Formats\Format;
use App\Infrastructure\Picture\Formats\FormatBuilderInterface;
use App\Infrastructure\Picture\Formats\Mobile;
use App\Infrastructure\Picture\Formats\Tablet;
use App\Infrastructure\Picture\PictureFormatter;
use App\Infrastructure\Picture\ResizerInterface;
use App\Tests\unit\_OM\Domain\PictureMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

class PictureFormatterTest extends TestCase
{
    private PictureFileStorage|MockObject $pictureFileStorage;
    private ResizerInterface|MockObject $resizer;
    private DirectoryInterface|MockObject $directory;
    private FormatBuilderInterface|MockObject $formatBuilder;

    protected function setUp(): void
    {
        $this->pictureFileStorage = $this->createMock(PictureFileStorage::class);
        $this->resizer = $this->createMock(ResizerInterface::class);
        $this->directory = $this->createMock(DirectoryInterface::class);
        $this->formatBuilder = $this->createMock(FormatBuilderInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->pictureFileStorage,
            $this->resizer,
            $this->directory,
            $this->formatBuilder,
        );
    }

    public function testShouldRemoveAllFiles(): void
    {
        // Given
        $path = uniqid();

        $this->directory
            ->expects($this->exactly(3))
            ->method('remove')
            ->with(
                $this->logicalOr(
                    'original/' . $path,
                    (new Mobile())->getLocation() . '/' . $path,
                    (new Tablet())->getLocation() . '/' . $path,
                )

            );

        // When
        $this->createInstanceUnderTest()->remove($path);

        // Then
        $this->assertFalse($this->doesNotPerformAssertions());
    }

    public function testShouldRunFormatterWithNewDimensions(): void
    {
        // Given
        $picture = PictureMother::createDefault();
        $file = new SplFileInfo(__DIR__ . '/../../../../public/core/dragon-ball-db.jpg');
        $formattedFile1 = new SplFileInfo(__DIR__ . '/../../../../public/core/dummy-img-1280x720.jpg');
        $formattedFile2 = new SplFileInfo(__DIR__ . '/../../../../public/core/dummy-img-1281x721.jpg');

        $this->pictureFileStorage
            ->expects($this->once())
            ->method('get')
            ->with($picture)
            ->willReturn($file);

        $this->directory
            ->expects($this->once())
            ->method('link')
            ->with('original/' . $source = $picture->source()->__toString(), $file);

        $this->formatBuilder
            ->expects(self::exactly(2))
            ->method('build')
            ->with(
                $this->logicalOr(
                    1014, 1920, 'small',
                    1014, 1920, 'medium'
                )
            )
            ->willReturnOnConsecutiveCalls(
                $format1 = new Format(100, 200, 'small'),
                $format2 = new Format(200, 300, 'medium')
            );

        $this->resizer
            ->expects(self::exactly(2))
            ->method('newDimensions')
            ->with(
                $this->logicalOr(
                    $file, $format1,
                    $file, $format2
                )
            )
            ->willReturnOnConsecutiveCalls(
                $dimension1 = new Dimensions(100, 200),
                $dimension2 = new Dimensions(200, 300)
            );

        $this->resizer
            ->expects(self::exactly(2))
            ->method('resize')
            ->with(
                $this->logicalOr(
                    $file, $dimension1,
                    $file, $dimension2
                )
            )
            ->willReturnOnConsecutiveCalls(
                $formattedFile1, $formattedFile2
            );

        $this->directory
            ->expects(self::exactly(2))
            ->method('put')
            ->with(
                $this->logicalOr(
                    'small' . '/' . $source, $formattedFile1,
                    'medium' . '/' . $source, $formattedFile2
                )
            );

        // When
        $this->createInstanceUnderTest()->run($picture);

        // Then
        $this->assertFalse($this->doesNotPerformAssertions());
    }

    public function testShouldRunFormatterWithLinkImage(): void
    {
        // Given
        $picture = PictureMother::createDefault();
        $file = new SplFileInfo(__DIR__ . '/../../../../public/core/dragon-ball-db.jpg');

        $this->pictureFileStorage
            ->expects($this->once())
            ->method('get')
            ->with($picture)
            ->willReturn($file);

        $this->formatBuilder
            ->expects(self::exactly(2))
            ->method('build')
            ->with(
                $this->logicalOr(
                    1014, 1920, 'small',
                    1014, 1920, 'medium'
                )
            )
            ->willReturnOnConsecutiveCalls(
                $format1 = new Format(100, 200, 'small'),
                $format2 = new Format(200, 300, 'medium')
            );

        $this->resizer
            ->expects(self::exactly(2))
            ->method('newDimensions')
            ->with(
                $this->logicalOr(
                    $file, $format1,
                    $file, $format2
                )
            )
            ->willReturnOnConsecutiveCalls(
                null, null
            );

        $this->directory
            ->expects(self::exactly(3))
            ->method('link')
            ->with(
                $this->logicalOr(
                    'original/' . $source = $picture->source()->__toString(), $file,
                    'small' . '/' . $source, $file,
                    'medium' . '/' . $source, $file,
                )
            );

        // When
        $this->createInstanceUnderTest()->run($picture);

        // Then
        $this->assertFalse($this->doesNotPerformAssertions());
    }

    private function createInstanceUnderTest(): PictureFormatter
    {
        return new PictureFormatter($this->pictureFileStorage, $this->resizer, $this->directory, $this->formatBuilder);
    }
}
