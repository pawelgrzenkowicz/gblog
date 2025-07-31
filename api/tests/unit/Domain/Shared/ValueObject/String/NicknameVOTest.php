<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\String\NicknameVO;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NicknameVOTest extends TestCase
{
    public static function provideValidNicknames(): array
    {
        return [
            [
                'nickname' => 'Paweł'
            ],
            [
                'nickname' => 'Paw'
            ],
            [
                'nickname' => 'P123456789A123456789W123456789'
            ],
        ];
    }

    #[DataProvider('provideValidNicknames')]
    public function testShouldCreateValidObject(string $nickname): void
    {
        // When
        $emailVO = $this->createInstanceUnderTest($nickname);

        // Then
        $this->assertSame($emailVO->__toString(), $nickname);
    }

    public function testShouldThrowExceptionWhenNicknameIsTooShort(): void
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);

        // When
        $this->createInstanceUnderTest('Pa');
    }

    public function testShouldThrowExceptionWhenNicknameIsTooLong(): void
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);

        // When
        $this->createInstanceUnderTest('P123456789A123456789W123456789E');
    }

    private function createInstanceUnderTest(string $value): NicknameVO
    {
        return new NicknameVO($value);
    }
}
