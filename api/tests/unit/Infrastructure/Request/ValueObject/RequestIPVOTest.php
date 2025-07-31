<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Request\ValueObject;

use App\Infrastructure\Request\ValueObject\RequestIPVO;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RequestIPVOTest extends TestCase
{
    public function testShouldReturnValidStringValue(): void
    {
        // Then
        $this->assertSame($value = '127.0.0.1', (string)$this->createInstanceUnderTest($value));
    }

    public function testShouldThrowExceptionWhenValueIsNotIP(): void
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);

        // When
        $this->createInstanceUnderTest(uniqid());

    }

    private function createInstanceUnderTest(string $value): RequestIPVO
    {
        return new RequestIPVO($value);
    }
}
