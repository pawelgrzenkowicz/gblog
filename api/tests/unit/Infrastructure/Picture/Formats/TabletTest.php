<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Picture\Formats;

use App\Infrastructure\Picture\Formats\ResizeFormat;
use App\Infrastructure\Picture\Formats\Tablet;
use PHPUnit\Framework\TestCase;

class TabletTest extends TestCase
{
    public function testShouldCreateValidClass(): void
    {
        // Given
        $actual = new Tablet();
        
        // Then
        $this->assertInstanceOf(ResizeFormat::class ,$actual);
        $this->assertSame($actual->getLocation(), 'medium');
        $this->assertSame($actual->getScaleDown(), 1.5);
    }
}
