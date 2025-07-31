<?php

declare(strict_types=1);

namespace App\Tests\unit\_OM\Domain;

use App\Domain\Shared\Enum\Role;
use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\Shared\ValueObject\String\NicknameVO;
use App\Domain\Shared\ValueObject\String\PasswordVO;
use App\Domain\Shared\ValueObject\String\PlainPasswordVO;
use App\Domain\User\User;
use App\Tests\unit\_OM\Domain\Shared\ValueObject\String\PasswordVOMother;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserMother
{
    private const DEFAULT_UUID = 'd1bb861a-d0d5-4ce5-81fa-c5d0f904f75e';
    private const DEFAULT_EMAIL = 'coscos@gmail.com';
    private const DEFAULT_NICKNAME = 'RANDOM_NICKNAME';
    private const DEFAULT_PASSWORD = 'CosCos123!';

    public static function create(
        UuidInterface $uuid,
        EmailVO $email,
        NicknameVO $nicknameVO,
        PasswordVO $password,
        Role $role,
        bool $removed = false
    ): User {
        return new User($uuid, $email, $nicknameVO, $password, $role, $removed);
    }

    public static function withRandomPassword(EmailVO $email): User
    {
        return self::create(
            Uuid::uuid4(),
            $email,
            new NicknameVO(uniqid()),
            PasswordVOMother::random(), Role::FREE_USER
        );
    }

    public static function createDefault(): User
    {
        return self::create(
            Uuid::fromString(self::DEFAULT_UUID),
            new EmailVO(self::DEFAULT_EMAIL),
            new NicknameVO(self::DEFAULT_NICKNAME),
            PasswordVO::fromPlainPassword(new PlainPasswordVO(self::DEFAULT_PASSWORD)),
            Role::FREE_USER
        );
    }
}
