<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\Number;

use App\Domain\Shared\ValueObject\LogMessage;
use App\Domain\Shared\ValueObject\Number\NonNegativeVO;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NonNegativeVOTest extends TestCase
{
    public static function provideNumbers(): array
    {
        return [
            [1],
            [2],
        ];
    }

    #[DataProvider('provideNumbers')]
    public function testShouldReturnIntAsString(int $number): void
    {
        // Then
        $this->assertEquals(sprintf('%d', $number), $this->createInstanceUnderTest($number)->__toString());
        $this->assertEquals((int) sprintf('%d', $number), $this->createInstanceUnderTest($number)->toInteger());
    }

    public function testShouldThrowExceptionWhenNumberIsTooLow()
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(LogMessage::log(NonNegativeVO::class, "0"));

        // Then
        $this->createInstanceUnderTest(0);
    }

    private function createInstanceUnderTest(int $value): NonNegativeVO
    {
        return new NonNegativeVO($value);
    }
}
