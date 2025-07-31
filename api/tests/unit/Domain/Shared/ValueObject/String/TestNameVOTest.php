<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\Shared\ValueObject\String\TestNameVO;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TestNameVOTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // When
        $emailVO = $this->createInstanceUnderTest($name = 'P');

        // Then
        $this->assertSame($emailVO->__toString(), $name);
    }

    public function testShouldThrowExceptionWhenEmailIsNotValid(): void
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);

        // When
        $this->createInstanceUnderTest('');
    }

    private function createInstanceUnderTest(string $value): TestNameVO
    {
        return new TestNameVO($value);
    }
}
