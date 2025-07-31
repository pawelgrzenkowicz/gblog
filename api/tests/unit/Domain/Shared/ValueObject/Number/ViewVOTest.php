<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\Number;

use App\Domain\Shared\ValueObject\LogMessage;
use App\Domain\Shared\ValueObject\Number\NaturalNumberVO;
use App\Domain\Shared\ValueObject\Number\ViewsVO;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ViewVOTest extends TestCase
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
        $this->expectExceptionMessage(LogMessage::log(ViewsVO::class, "-1"));

        // Then
        $this->createInstanceUnderTest(-1);
    }

    private function createInstanceUnderTest(int $value): ViewsVO
    {
        return new ViewsVO($value);
    }
}
