<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\LogMessage;
use App\Domain\Shared\ValueObject\String\TitleVO;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TitleVOTest extends TestCase
{
    public static function provideTitles(): array
    {
        return [
            [
                'title' => 'P',
            ],
            [
                'title' => uniqid(),
            ],
        ];
    }

    /**
     * @dataProvider provideTitles
     */

    #[DataProvider('provideTitles')]
    public function testShouldCheckIfPictureNameIsValid(string $title): void
    {
        // Then
        $this->assertEquals($title, $this->createInstanceUnderTest($title));
    }

    public function testShouldThrowException(): void
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(LogMessage::log(TitleVO::class, ''));

        // When
        $this->createInstanceUnderTest('');
    }

    private function createInstanceUnderTest(string $value): TitleVO
    {
        return new TitleVO($value);
    }
}
