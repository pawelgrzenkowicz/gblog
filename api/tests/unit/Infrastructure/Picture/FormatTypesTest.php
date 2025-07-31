<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Picture;

use App\Infrastructure\Picture\Formats\ResizeFormat;
use App\Infrastructure\Picture\FormatTypes;
use PHPUnit\Framework\TestCase;

class FormatTypesTest extends TestCase
{
    public function testShouldReturnValidObjects(): void
    {
        // When
        $actual = $this->createInstanceUnderTest();

        // Then
        foreach ($actual::get() as $type) {
            $this->assertInstanceOf(ResizeFormat::class, $type);
        }
    }

    public function createInstanceUnderTest(): FormatTypes
    {
        return new FormatTypes();
    }
}
