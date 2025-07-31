<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\External;
use App\Domain\ExternalTrait;
use App\Domain\Internal;
use App\Domain\Shared\Enum\Role;
use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\Shared\ValueObject\String\NicknameVO;
use App\Domain\Shared\ValueObject\String\PasswordVO;
use Ramsey\Uuid\UuidInterface;

class User
{
    use ExternalTrait;

    #[Internal]
    public readonly UuidInterface $uuid;

    #[External]
    private EmailVO $email;

    #[External]
    private NicknameVO $nickname;

    #[External]
    private PasswordVO $password;

    #[External]
    private Role $role;

    #[External]
    private bool $removed;

    public function __construct(
        UuidInterface $uuid,
        EmailVO $email,
        NicknameVO $nickname,
        PasswordVO $password,
        Role $role,
        bool $removed = false
    ) {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->nickname = $nickname;
        $this->password = $password;
        $this->role = $role;
        $this->removed = $removed;
    }

    public function email(): EmailVO
    {
        return $this->email;
    }

    public function nickname(): NicknameVO
    {
        return $this->nickname;
    }

    public function password(): PasswordVO
    {
        return $this->password;
    }

    public function role(): Role
    {
        return $this->role;
    }

    public function removed(): bool
    {
        return $this->removed;
    }
}
