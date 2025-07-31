<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Picture;

use App\Infrastructure\Picture\Dimensions;
use App\Infrastructure\Picture\Formats\Format;
use App\Infrastructure\Picture\PictureOrientationCalculatorInterface;
use App\Infrastructure\Picture\Resizer;
use App\Infrastructure\Symfony\Service\TemporaryRouteGenerator;
use Imagine\Imagick\Imagine;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

class ResizerTest extends TestCase
{
    private Imagine|MockObject $imagine;
    private PictureOrientationCalculatorInterface|MockObject $pictureOrientationCalculator;
    private TemporaryRouteGenerator|MockObject $temporaryRouteGenerator;

    protected function setUp(): void
    {
        $this->imagine = $this->createMock(Imagine::class);
        $this->pictureOrientationCalculator = $this->createMock(PictureOrientationCalculatorInterface::class);
        $this->temporaryRouteGenerator = $this->createMock(TemporaryRouteGenerator::class);

        if (!is_dir($dir = __DIR__ . '/../../../../var/tmp/')) {
            mkdir($dir, 0777, true);
        }
    }

    protected function tearDown(): void
    {
        unset(
            $this->imagine,
            $this->pictureOrientationCalculator,
            $this->temporaryRouteGenerator,
        );
    }

    public static function provideImageToResize(): array
    {
        return [
            [
                'file' => new SplFileInfo(__DIR__ . '/../../../../public/core/dragon-ball-db.jpg'),
                'dimensions' => new Dimensions(11, 21),
            ],
        ];
    }

    #[DataProvider('provideImageToResize')]
    public function testShouldResizeImage(SplFileInfo $file, Dimensions $dimensions): void
    {
        // Given
        $this->temporaryRouteGenerator
            ->expects($this->once())
            ->method('generate')
            ->with('resize')
            ->willReturn($path = __DIR__ . '/../../../../var/tmp/' . uniqid());

        $imagine = new Imagine();
        $imagineImage = $imagine->open($file->getRealPath());

        $this->imagine
            ->expects($this->once())
            ->method('open')
            ->with($file->getPathname())
            ->willReturn($imagineImage);

        // When
        $actual = $this->createInstanceUnderTest()->resize($file, $dimensions);

        // Then
        $this->assertEquals(new SplFileInfo($path), $actual);
        $this->assertLessThan($file->getSize(), $actual->getSize());
    }

    public static function provideImageToResizeWithFormat(): array
    {
        return [
            [
                'file' => new SplFileInfo(__DIR__ . '/../../../../public/core/dummy-img-400x400.jpg'),
                'format' => new Format(401, 399, 'medium'),
                'ratio' => 1.0
            ],
            [
                'file' => new SplFileInfo(__DIR__ . '/../../../../public/core/dummy-img-1281x721.jpg'),
                'format' => new Format(720, 1280, 'medium'),
                'ratio' => 1.7766990291262137
            ],
        ];
    }

    #[DataProvider('provideImageToResizeWithFormat')]
    public function testShouldReturnNewDimensions(SplFileInfo $file, Format $format, float $ratio): void
    {
        // Given
        $this->pictureOrientationCalculator
            ->expects($this->once())
            ->method('calculate')
            ->with($format, $ratio)
            ->willReturn($dimensions = new Dimensions(rand(1, 10), rand(1, 10)));

        // When
        $actual = $this->createInstanceUnderTest()->newDimensions($file, $format);

        // Then
        $this->assertEquals($dimensions, $actual);
    }

    public static function provideImageToReturnNull(): array
    {
        return [
            [
                'file' => new SplFileInfo(__DIR__ . '/../../../../public/core/dummy-img-1280x720.jpg'),
                'format' => new Format(720, 1280, 'medium'),
            ],
            [
                'file' => new SplFileInfo(__DIR__ . '/../../../../public/core/dummy-img-1280x720.jpg'),
                'format' => new Format(720.1, 1280.1, 'medium'),
            ],
        ];
    }

    #[DataProvider('provideImageToReturnNull')]
    public function testShouldReturnNull(SplFileInfo $file, Format $format): void
    {
        // When
        $actual = $this->createInstanceUnderTest()->newDimensions($file, $format);

        // Then
        $this->assertNull($actual);
    }

    private function createInstanceUnderTest(): Resizer
    {
        return new Resizer($this->imagine, $this->pictureOrientationCalculator, $this->temporaryRouteGenerator);
    }
}
