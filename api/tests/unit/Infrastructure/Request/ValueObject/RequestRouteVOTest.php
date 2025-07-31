<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Request\ValueObject;

use App\Infrastructure\Request\ValueObject\RequestRouteVO;
use PHPUnit\Framework\TestCase;

class RequestRouteVOTest extends TestCase
{
    public function testShouldReturnValidStringValue(): void
    {
        // Then
        $this->assertSame($value = uniqid(), (string)$this->createInstanceUnderTest($value));
    }

    private function createInstanceUnderTest(string $value): RequestRouteVO
    {
        return new RequestRouteVO($value);
    }
}
