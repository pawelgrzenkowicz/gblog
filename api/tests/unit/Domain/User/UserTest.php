<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\User;

use App\Domain\Shared\Enum\Role;
use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\Shared\ValueObject\String\NicknameVO;
use App\Domain\Shared\ValueObject\String\PasswordVO;
use App\Domain\Shared\ValueObject\String\PlainPasswordVO;
use App\Domain\User\User;
use App\Tests\unit\_OM\Domain\Shared\ValueObject\String\PasswordVOMother;
use App\Tests\unit\_OM\Domain\UserMother;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserTest extends TestCase
{
    public static function provideUserData(): array
    {
        return [
            [
                'uuid' => Uuid::uuid4(),
                'email' => sprintf('%s@gmail.com', uniqid()),
                'nickname' => uniqid(),
                'password' => 'CosCos1!',
                'removed' => true,
            ],
            [
                'uuid' => Uuid::uuid4(),
                'email' => sprintf('%s@gmail.com', uniqid()),
                'nickname' => uniqid(),
                'password' => 'CosCos2!',
                'removed' => false,
            ],
        ];
    }

    #[DataProvider('provideUserData')]
    public function testShouldCreateValidObject(
        UuidInterface $uuid,
        string $email,
        string $nickname,
        string $password,
        bool $removed
    ): void {
        // When
        $userClass = $this->createInstanceUnderTest($uuid, $email, $nickname, $password, $removed);

        // Then
        $this->assertSame($uuid, $userClass->uuid);
        $this->assertSame($email, $userClass->email()->__toString());
        $this->assertSame($nickname, $userClass->nickname()->__toString());
        $this->assertSame(Role::FREE_USER, $userClass->role());
        $this->assertSame($removed, $userClass->removed());
        $this->assertInstanceOf(PasswordVO::class, $userClass->password());
    }

    public function testShouldCreateUserWithDefaultRemoved(): void
    {
        // When
        $actual = new User(
            Uuid::uuid4(),
            new EmailVO('test@test.com'),
            new NicknameVO(uniqid()),
            PasswordVOMother::fromPlainPasswordVO(new PlainPasswordVO('Password123!')),
            Role::FREE_USER
            );

        // Then
        $this->assertFalse($actual->removed());
    }

    private function createInstanceUnderTest(
        UuidInterface $uuid,
        string $email,
        string $nickname,
        string $password,
        bool $removed
    ): User {
        return UserMother::create(
            $uuid,
            new EmailVO($email),
            new NicknameVO($nickname),
            PasswordVOMother::fromPlainPasswordVO(new PlainPasswordVO($password)),
            Role::FREE_USER,
            $removed
        );
    }
}
