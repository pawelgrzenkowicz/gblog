<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\Number;

use App\Domain\Shared\ValueObject\LogMessage;
use App\Domain\Shared\ValueObject\Number\NaturalNumberVO;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NaturalNumberVOTest extends TestCase
{
    public static function provideNumbers(): array
    {
        return [
            [
                'number' => 0
            ],
            [
                'number' => 1
            ],
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
        $this->expectExceptionMessage(LogMessage::log(NaturalNumberVO::class, "-1"));

        // Then
        $this->createInstanceUnderTest(-1);
    }

    private function createInstanceUnderTest(int $value): NaturalNumberVO
    {
        return new NaturalNumberVO($value);
    }
}
