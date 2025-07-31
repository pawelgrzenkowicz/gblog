<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\Number;

use App\Domain\Shared\ValueObject\LogMessage;
use App\Domain\Shared\ValueObject\Number\TestNumberVO;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TestNumberVOTest extends TestCase
{
    public static function provideNumbers(): array
    {
        return [
            [1],
            [100],
        ];
    }

    #[DataProvider('provideNumbers')]
    public function testShouldReturnIntAsString(int $number): void
    {
        // Then
        $this->assertEquals(sprintf('%d', $number), $this->createInstanceUnderTest($number)->__toString());
    }

    public function testShouldThrowErrorWhenNumberIsTooHigh()
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);

        // Then
        $this->createInstanceUnderTest(101);
    }

    public function testShouldThrowErrorWhenNumberIsTooLow()
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(LogMessage::log(TestNumberVO::class, "0"));

        // Then
        $this->createInstanceUnderTest(0);
    }

    private function createInstanceUnderTest(int $value): TestNumberVO
    {
        return new TestNumberVO($value);
    }
}
