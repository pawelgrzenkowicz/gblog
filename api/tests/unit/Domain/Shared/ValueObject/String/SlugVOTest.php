<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\LogMessage;
use App\Domain\Shared\ValueObject\String\SlugVO;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SlugVOTest extends TestCase
{
    public static function provideSlugs(): array
    {
        return [
            [
                'slug' => 'P',
            ],
            [
                'slug' => uniqid(),
            ],
        ];
    }

    #[DataProvider('provideSlugs')]
    public function testShouldCheckIfPictureNameIsValid(string $slug): void
    {
        // Then
        $this->assertEquals($slug, $this->createInstanceUnderTest($slug));
    }

    public static function provideInvalidSlugs(): array
    {
        return [
            [
                'slug' => '',
            ],
            [
                'slug' => ' ',
            ],
            [
                'slug' => '/',
            ],
        ];
    }

    #[DataProvider('provideInvalidSlugs')]
    public function testShouldThrowException(string $slug): void
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(LogMessage::log(SlugVO::class, $slug));

        // When
        $this->createInstanceUnderTest($slug);
    }

    private function createInstanceUnderTest(string $value): SlugVO
    {
        return new SlugVO($value);
    }
}
