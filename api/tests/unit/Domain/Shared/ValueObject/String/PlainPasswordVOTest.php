<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\String\PlainPasswordVO;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PlainPasswordVOTest extends TestCase
{
    public static function provideValidPlainPasswords(): array
    {
        return [
            'standard' => [
                'Password1!',
            ],
            'eight-characters' => [
                'Passwo1!',
            ],
            'long' => [
                'Password!1Password!2Password!3Password!4Password!5',
            ],
        ];
    }

    #[DataProvider('provideValidPlainPasswords')]
    public function testShouldCreateValidPlainPassword(string $password): void
    {
        // When
        $plainPasswordVO = $this->createInstanceUnderTest($password);

        // Then
        $this->assertSame($plainPasswordVO->__toString(), $password);
    }

    public static function provideWrongPasswords(): array
    {
        return [
            [
                'password' => 'Passwor',
            ],
            [
                'password' => 'Password!1Password!2Password!3Password!4Password!5P',
            ],
            [
                'password' => 'password1!',
            ],
            [
                'password' => 'PASSWORD1!',
            ],
            [
                'password' => 'PaSSWORD1',
            ],
            [
                'password' => 'PaSSWORD!',
            ],
            [
                'password' => 'PaS SWORD1!',
            ],
            [
                'password' => 'Pa1!sss',
            ],
        ];
    }

    #[DataProvider('provideWrongPasswords')]
    public function testShouldReturnException(string $password): void
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);

        // When
        $this->createInstanceUnderTest($password);
    }

    private function createInstanceUnderTest(string $value): PlainPasswordVO
    {
        return new PlainPasswordVO($value);
    }
}
