<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Picture\Formats;

use App\Infrastructure\Picture\Formats\Format;
use App\Infrastructure\Picture\Formats\FormatBuilder;
use App\Infrastructure\Picture\Formats\Mobile;
use App\Infrastructure\Picture\Formats\ResizeFormat;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FormatBuilderTest extends TestCase
{
    public static function provideDimensions(): array
    {
        return [
            [
                'height' => 100,
                'width' => 100,
                'format' => new Mobile(),
                'expected' => new Format(50, 50, 'small'),
            ],
        ];
    }

    #[DataProvider('provideDimensions')]
    public function testShouldReturnValidFormat(
        float $height,
        float $width,
        ResizeFormat $format,
        Format $expected
    ): void {
        // When
        $actual = $this->createInstanceUnderTest()->build($height, $width, $format);

        // Then
        $this->assertEquals($expected, $actual);
    }

    private function createInstanceUnderTest(): FormatBuilder
    {
        return new FormatBuilder();
    }
}
