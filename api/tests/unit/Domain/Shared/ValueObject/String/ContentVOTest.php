<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\String\ContentVO;
use PHPUnit\Framework\TestCase;

class ContentVOTest extends TestCase
{
    public function testShouldReturnStringVariableValue(): void
    {
        // Then
        $this->assertSame($value = uniqid(), $this->createInstanceUnderTest($value)->__toString());
    }

    private function createInstanceUnderTest(string $value): ContentVO
    {
        return new ContentVO($value);
    }
}
