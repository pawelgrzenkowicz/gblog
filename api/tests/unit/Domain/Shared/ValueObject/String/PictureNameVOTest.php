<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\LogMessage;
use App\Domain\Shared\ValueObject\String\PictureNameVO;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PictureNameVOTest extends TestCase
{
    public static function providePictureNames(): array
    {
        return [
            [
                'pictureName' => 'P',
            ],
            [
                'pictureName' => uniqid(),
            ],
        ];
    }

    #[DataProvider('providePictureNames')]
    public function testShouldCheckIfPictureNameIsValid(string $pictureName): void
    {
        // Then
        $this->assertEquals($pictureName, $this->createInstanceUnderTest($pictureName));
    }

    public static function provideWrongPictureNames(): array
    {
        return [
            [
                'pictureName' => '',
            ],
            [
                'pictureName' => ' ',
            ],
            [
                'pictureName' => '/',
            ],
        ];
    }

    #[DataProvider('provideWrongPictureNames')]
    public function testShouldThrowException(string $pictureName): void
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(LogMessage::log(PictureNameVO::class, $pictureName));

        // When
        $this->createInstanceUnderTest($pictureName);
    }

    private function createInstanceUnderTest(string $value): PictureNameVO
    {
        return new PictureNameVO($value);
    }
}
