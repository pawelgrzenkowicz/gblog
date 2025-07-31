<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Request\ValueObject;

use App\Infrastructure\Request\ValueObject\RequestDateVO;
use PHPUnit\Framework\TestCase;

class RequestDateVOTest extends TestCase
{
    private const DEFAULT_DATETIME = '1994-06-30T17:40:00+00:00';

    public function testShouldReturnValidStringValue(): void
    {
        // Then
        $this->assertSame($value = self::DEFAULT_DATETIME, $this->createInstanceUnderTest($value)->toAtom());
    }

    private function createInstanceUnderTest(string $value): RequestDateVO
    {
        return new RequestDateVO($value);
    }
}
