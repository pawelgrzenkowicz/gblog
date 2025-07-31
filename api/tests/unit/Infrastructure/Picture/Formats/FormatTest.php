<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Picture\Formats;

use App\Infrastructure\Picture\Formats\Format;
use Codeception\PHPUnit\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class FormatTest extends TestCase
{
    public static function provideHeightRatio(): array
    {
        return [
            [
                'height' => 2,
                'width' => 4,
                'result' => 0.5,
            ],
            [
                'height' => 10,
                'width' => 5,
                'result' => 2.0,
            ],
            [
                'height' => 99,
                'width' => 8,
                'result' => 12.38,
            ],
        ];
    }

    #[DataProvider('provideHeightRatio')]
    public function testShouldCalcValidHeightRatio(int $height, int $width, float $result): void
    {
        // When
        $actual = $this->createInstanceUnderTest($height, $width, uniqid())->heightRatio();

        // Then
        $this->assertEquals($result, $actual);
    }

    public static function provideWidthRatio(): array
    {
        return [
            [
                'height' => 2,
                'width' => 4,
                'result' => 2.0,
            ],
            [
                'height' => 10,
                'width' => 5,
                'result' => 0.5,
            ],
            [
                'height' => 8,
                'width' => 99,
                'result' => 12.38,
            ],
        ];
    }

    #[DataProvider('provideWidthRatio')]
    public function testShouldCalcValidWidthRatio(int $height, int $width, float $result): void
    {
        // When
        $actual = $this->createInstanceUnderTest($height, $width, uniqid())->widthRatio();

        // Then
        $this->assertEquals($result, $actual);
    }

    private function createInstanceUnderTest(int $height, int $width, string $location): Format
    {
        return new Format($height, $width, $location);
    }
}
