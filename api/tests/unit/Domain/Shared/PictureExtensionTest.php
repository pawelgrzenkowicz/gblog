<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared;

use App\Domain\Shared\Enum\PictureExtension;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PictureExtensionTest extends TestCase
{
    public function testShouldThrowExceptionWhenExceptionIsNotValid(): void
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);

        // When
        PictureExtension::fromString(uniqid());
    }
}
