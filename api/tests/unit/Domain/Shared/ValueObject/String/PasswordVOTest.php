<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\String\PasswordVO;
use App\Domain\Shared\ValueObject\String\PlainPasswordVO;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PasswordVOTest extends TestCase
{
    public static function providePasswordsProvider(): array
    {
        return [
            [
                'plainPassword' => 'CosCos123!',
            ],
            [
                'plainPassword' => '123!Ktos321',
            ],
        ];
    }

    #[DataProvider('providePasswordsProvider')]
    public function testShouldCheckMatchedPassword(string $plainPassword): void
    {
        // Then
        $this->assertTrue($this->createInstanceUnderTest(
            new PlainPasswordVO($plainPassword))->matches($plainPassword)
        );
    }

    public function testShouldReturnStringPassword(): void
    {
        // When
        $passwordVO = PasswordVO::fromString($password = 'Password123!');

        // Then
        $this->assertSame($passwordVO->__toString(), $password);
    }

    public function testShouldReturnHashedPassword(): void
    {
        // When
        $passwordVO = PasswordVO::fromPlainPassword(new PlainPasswordVO($password = 'Password123!'));

        // Then
        $this->assertInstanceOf(PasswordVO::class, $passwordVO);
    }

    public function testShouldCheckConst(): void
    {
        // When
        $passwordVO = $this->createInstanceUnderTest(new PlainPasswordVO('Password123!'));

        // Then
        $this->assertSame($passwordVO::COST, 13);
        $this->assertSame($passwordVO::ALGORITHM, '2y');
    }

    public function testShouldTestHashMethod(): void
    {
        // Given
        $hashedPassword = '$2y$13$d.G9pPYxco25OqMSo0Ai3eJN7YnyMFyTVBWmsgQPSoPgQS0/6FUK.';
        $password = 'Password123!';

        // When
        $passwordVO = PasswordVO::fromString($hashedPassword);

        // Then
        $this->assertTrue($passwordVO->matches($password));
    }

    private function createInstanceUnderTest(PlainPasswordVO $plainPasswordVO): PasswordVO
    {
        return PasswordVO::fromPlainPassword($plainPasswordVO);
    }
}
