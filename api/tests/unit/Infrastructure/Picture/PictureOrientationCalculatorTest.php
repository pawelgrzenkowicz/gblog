<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Picture;

use App\Infrastructure\Picture\Dimensions;
use App\Infrastructure\Picture\Formats\Format;
use App\Infrastructure\Picture\PictureOrientationCalculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PictureOrientationCalculatorTest extends TestCase
{
    public static function provideDataForCalculate(): array
    {
        return [
            [
                'format' => new Format(109.5, 199.0, 'medium'),
                'ratio' => 1.2333,
                'expected' => new Dimensions(135.05, 109.5),
            ],
            [
                'format' => new Format(199.0, 100.0, 'medium'),
                'ratio' => 1.2333,
                'expected' => new Dimensions(100, 81.08),
            ],
            [
                'format' => new Format(720.0, 1280.0, 'medium'),
                'ratio' => 1.78,
                'expected' => new Dimensions(1280.0, 719.1),
            ],
        ];
    }

    #[DataProvider('provideDataForCalculate')]
    public function testShouldCalculateValidDimensions(Format $format, float $ratio, Dimensions $expected): void
    {
        // When
        $actual = $this->createInstanceUnderTest()->calculate($format, $ratio);

        // Then
        $this->assertEquals($expected, $actual);
    }
    private function createInstanceUnderTest(): PictureOrientationCalculator
    {
        return new PictureOrientationCalculator();
    }
}
