<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Picture;

use App\Infrastructure\Picture\Dimensions;
use PHPUnit\Framework\TestCase;

class DimensionsTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given

        // Exception

        // When
        $actual = $this->createInstanceUnderTest($width = $this->randomFloat(), $height = $this->randomFloat());

        // Then
        $this->assertSame($width, $actual->width);
        $this->assertSame($height, $actual->height);
    }

    private function createInstanceUnderTest(float $width, float $height): Dimensions
    {
        return new Dimensions($width, $height);
    }

    private function randomFloat(): float
    {
        return rand(1, 10)/10;
    }
}
