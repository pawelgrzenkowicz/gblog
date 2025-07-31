<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\LogMessage;
use App\Domain\Shared\ValueObject\String\PictureAltVO;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PictureAltVOTest extends TestCase
{
    public static function provideAlts(): array
    {
        return [
            [
                'alt' => 'P',
            ],
            [
                'alt' => uniqid(),
            ],
        ];
    }

    #[DataProvider('provideAlts')]
    public function testShouldCheckIfAltIsValid(string $alt): void
    {
        // Then
        $this->assertEquals($alt, $this->createInstanceUnderTest($alt));
    }

    public function testShouldThrowException(): void
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(LogMessage::log(PictureAltVO::class, ''));

        // When
        $this->createInstanceUnderTest('');
    }

    private function createInstanceUnderTest(string $value): PictureAltVO
    {
        return new PictureAltVO($value);
    }
}
