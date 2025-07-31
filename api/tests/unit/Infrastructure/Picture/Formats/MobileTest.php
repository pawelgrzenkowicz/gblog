<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Picture\Formats;

use App\Infrastructure\Picture\Formats\Mobile;
use App\Infrastructure\Picture\Formats\ResizeFormat;
use PHPUnit\Framework\TestCase;

class MobileTest extends TestCase
{
    public function testShouldCreateValidClass(): void
    {
        // Given
        $actual = new Mobile();

        // Then
        $this->assertInstanceOf(ResizeFormat::class ,$actual);
        $this->assertSame($actual->getLocation(), 'small');
        $this->assertSame($actual->getScaleDown(), 2.0);
    }
}
