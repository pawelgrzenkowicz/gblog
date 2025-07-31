<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\LogMessage;
use App\Domain\Shared\ValueObject\String\PictureSourceVO;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PictureSourceVOTest extends TestCase
{
    public static function provideSources(): array
    {
        return [
            [
                'source' => 'P',
            ],
            [
                'source' => uniqid(),
            ],
        ];
    }

    #[DataProvider('provideSources')]
    public function testShouldCheckIfPictureNameIsValid(string $source): void
    {
        // Then
        $this->assertEquals($source, $this->createInstanceUnderTest($source));
    }

    public static function provideInvalidSources(): array
    {
        return [
            [
                'source' => '',
            ],
            [
                'source' => sprintf('%s %s', uniqid(), uniqid()),
            ],
        ];
    }

    #[DataProvider('provideInvalidSources')]
    public function testShouldThrowException(string $source): void
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(LogMessage::log(PictureSourceVO::class, $source));

        // When
        $this->createInstanceUnderTest($source);
    }

    private function createInstanceUnderTest(string $value): PictureSourceVO
    {
        return new PictureSourceVO($value);
    }
}
